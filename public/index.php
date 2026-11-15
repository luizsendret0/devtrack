<?php
// DevTrack v0.3.0-alpha: ponto de entrada + autenticação.
// Se personalizou este arquivo, compare antes de substituir.
require_once __DIR__ . '/../app/config/session.php';
require_once __DIR__ . '/../app/helpers/security.php';

$page = $_GET['page'] ?? 'landing';
if (!is_string($page)) {
    http_response_code(404);
    exit('Página não encontrada.');
}
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if (in_array($page, ['login', 'register', 'logout'], true) && $method === 'POST') {
    require_once __DIR__ . '/../app/controllers/AuthController.php';
    $auth = new AuthController();
    if ($page === 'login') $auth->login();
    if ($page === 'register') $auth->register();
    if ($page === 'logout') $auth->logout();
}

/* =========================================
   UPLOAD DA FOTO DE PERFIL
========================================= */

if ($page === 'avatar-upload') {

    // Upload só pode ser feito por POST
    if ($method !== 'POST') {
        header('Allow: POST');
        http_response_code(405);
        exit('Método não permitido.');
    }

    // Exige usuário autenticado
    require __DIR__ . '/../app/middleware/auth.php';

    // Carrega o controller do perfil
    require_once __DIR__ . '/../app/controllers/ProfileController.php';

    // Processa a imagem
    $profile = new ProfileController();
    $profile->uploadAvatar();
}


if ($method !== 'GET') {
    header('Allow: GET, POST');
    http_response_code(405);
    exit('Método não permitido.');
}

if ($page === 'landing') {
    require __DIR__ . '/../views/layouts/landing-header.php';
    require __DIR__ . '/../views/landing/index.php';
    require __DIR__ . '/../views/layouts/landing-footer.php';
    exit;
}

if ($page === 'login' || $page === 'register') {
    if (!empty($_SESSION['user_id'])) redirect_to('dashboard');
    $feedback = pull_form_feedback($page);
    require __DIR__ . '/../views/layouts/auth-header.php';
    require __DIR__ . '/../views/auth/' . $page . '.php';
    require __DIR__ . '/../views/layouts/auth-footer.php';
    exit;
}

if ($page === 'logout') {
    http_response_code(405); // Sair exige POST + CSRF.
    header('Allow: POST');
    exit('Método não permitido.');
}

// Conteúdo privado — exige sessão válida.
$routes = [
    'dashboard' => 'dashboard/index.php',
    'jobs' => 'shared/coming-soon.php',
    'vacancies' => 'shared/coming-soon.php',
    'skills' => 'shared/coming-soon.php',
    'analytics' => 'shared/coming-soon.php',
    'goals' => 'shared/coming-soon.php',
    'studies' => 'shared/coming-soon.php',
    'trails' => 'shared/coming-soon.php',
    'contents' => 'shared/coming-soon.php',
    'exercises' => 'shared/coming-soon.php',
    'settings' => 'shared/coming-soon.php',
];

if (!isset($routes[$page])) {
    http_response_code(404);
    exit('Página não encontrada.');
}
require __DIR__ . '/../app/middleware/auth.php';
$view = __DIR__ . '/../views/' . $routes[$page];
require __DIR__ . '/../views/layouts/header.php';
require $view;
require __DIR__ . '/../views/layouts/footer.php';
