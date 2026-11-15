<?php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private function users(): User
    {
        // O database.php já existente no projeto DEVE retornar uma conexão PDO.
        $pdo = require __DIR__ . '/../config/database.php';
        if (!$pdo instanceof PDO) {
            throw new RuntimeException('database.php deve retornar uma conexão PDO.');
        }
        return new User($pdo);
    }

    public function register(): never
    {
        if (!csrf_valid()) {
            form_feedback('register', ['Sessão expirada. Atualize a página e tente novamente.']);
            redirect_to('register');
        }

        $name = trim((string) ($_POST['name'] ?? ''));
        $email = strtolower(trim((string) ($_POST['email'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');
        $confirmation = (string) ($_POST['password_confirmation'] ?? '');
        $errors = [];

        if ($name === '' || strlen($name) > 150) {
            $errors[] = 'Informe um nome de até 150 caracteres.';
        }
        if (strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Informe um e-mail válido.';
        }
        // PASSWORD_DEFAULT usa bcrypt nas versões atuais do PHP: limite de 72 bytes.
        if (strlen($password) < 8 || strlen($password) > 72) {
            $errors[] = 'A senha deve ter entre 8 e 72 bytes.';
        }
        if ($password !== $confirmation) {
            $errors[] = 'As senhas não coincidem.';
        }
        if ($errors) {
            form_feedback('register', $errors, ['name' => $name, 'email' => $email]);
            redirect_to('register');
        }

        try {
            $users = $this->users();
            if ($users->findByEmail($email)) {
                form_feedback('register', ['Este e-mail já está cadastrado.'], ['name' => $name, 'email' => $email]);
                redirect_to('register');
            }

            $id = $users->create($name, $email, password_hash($password, PASSWORD_DEFAULT));
        } catch (PDOException $e) {
            error_log('[DevTrack auth/register] ' . $e->getMessage());
            // Protege também contra a duplicidade durante cadastros simultâneos.
            $message = (string) $e->getCode() === '23000'
                ? 'Este e-mail já está cadastrado.'
                : 'Não foi possível criar sua conta. Tente novamente.';
            form_feedback('register', [$message], ['name' => $name, 'email' => $email]);
            redirect_to('register');
        } catch (Throwable $e) {
            error_log('[DevTrack auth/register] ' . $e->getMessage());
            form_feedback('register', ['Erro ao acessar o banco de dados. Verifique a configuração.']);
            redirect_to('register');
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        unset($_SESSION['auth_failures']);
        redirect_to('dashboard');
    }

    public function login(): never
    {
        if (!csrf_valid()) {
            form_feedback('login', ['Sessão expirada. Atualize a página e tente novamente.']);
            redirect_to('login');
        }

        $email = strtolower(trim((string) ($_POST['email'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');
        $now = time();
        $fails = $_SESSION['auth_failures'] ?? ['count' => 0, 'since' => $now];
        if (($now - ($fails['since'] ?? $now)) >= 900) {
            $fails = ['count' => 0, 'since' => $now];
        }
        if ($fails['count'] >= 5) {
            form_feedback('login', ['Muitas tentativas. Tente novamente em alguns minutos.'], ['email' => $email]);
            redirect_to('login');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            form_feedback('login', ['Informe seu e-mail e senha.'], ['email' => $email]);
            redirect_to('login');
        }

        try {
            $users = $this->users();
            $user = $users->findByEmail($email);
            if (!$user || !password_verify($password, $user['password'])) {
                $fails['count']++;
                $_SESSION['auth_failures'] = $fails;
                form_feedback('login', ['E-mail ou senha incorretos.'], ['email' => $email]);
                redirect_to('login');
            }
            if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
                $users->updatePasswordHash((int) $user['id'], password_hash($password, PASSWORD_DEFAULT));
            }
        } catch (Throwable $e) {
            error_log('[DevTrack auth/login] ' . $e->getMessage());
            form_feedback('login', ['Não foi possível entrar. Verifique o banco de dados.'], ['email' => $email]);
            redirect_to('login');
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['user_name'] = $user['name'];
        unset($_SESSION['auth_failures']);
        redirect_to('dashboard');
    }

    public function logout(): never
    {
        if (!csrf_valid()) {
            http_response_code(403);
            exit('Requisição inválida.');
        }
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', [
                'expires' => time() - 3600,
                'path' => $params['path'],
                'domain' => $params['domain'],
                'secure' => $params['secure'],
                'httponly' => $params['httponly'],
                'samesite' => $params['samesite'] ?? 'Lax',
            ]);
        }
        session_destroy();
        redirect_to('landing');
    }
}
