<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Job.php';

class JobController
{
    private const STATUSES = [
        'salva' => 'Salva',
        'candidatado' => 'Candidatado',
        'entrevista' => 'Entrevista',
        'aprovado' => 'Aprovado',
        'recusado' => 'Recusado',
        'desistiu' => 'Desistiu',
    ];

    private const WORK_MODELS = [
        'presencial' => 'Presencial', 'hibrido' => 'Híbrido', 'remoto' => 'Remoto',
    ];

    private const EMPLOYMENT_TYPES = [
        'estagio' => 'Estágio', 'junior' => 'Júnior',
        'pleno' => 'Pleno', 'senior' => 'Sênior', 'outro' => 'Outro',
    ];

    private function jobs(): Job
    {
        $pdo = require __DIR__ . '/../config/database.php';
        if (!$pdo instanceof PDO) {
            throw new RuntimeException('A conexão em app/config/database.php deve retornar um PDO.');
        }
        return new Job($pdo);
    }

    public function handle(string $method): never
    {
        $action = $_GET['action'] ?? 'index';
        if (!is_string($action)) {
            $this->notFound();
        }

        // Nunca processa gravação usando GET.
        $postActions = ['store', 'update', 'delete', 'status'];
        $getActions = ['index', 'create', 'edit', 'show'];
        if (in_array($action, $postActions, true) && $method !== 'POST') {
            $this->methodNotAllowed('POST');
        }
        if (in_array($action, $getActions, true) && $method !== 'GET') {
            $this->methodNotAllowed('GET');
        }
        if (!in_array($action, [...$postActions, ...$getActions], true)) {
            $this->notFound();
        }
        if ($method === 'POST' && !csrf_valid()) {
            http_response_code(403);
            exit('Requisição inválida. Atualize a página e tente novamente.');
        }

        try {
            match ($action) {
                'index' => $this->index(),
                'create' => $this->create(),
                'show' => $this->show(),
                'edit' => $this->edit(),
                'store' => $this->store(),
                'update' => $this->update(),
                'delete' => $this->destroy(),
                'status' => $this->changeStatus(),
            };
        } catch (PDOException $exception) {
            error_log('[DevTrack jobs] ' . $exception->getMessage());
            http_response_code(500);
            exit('Não foi possível acessar as candidaturas. Verifique a conexão com o MySQL.');
        }
        exit;
    }

    private function index(): void
    {
        $userId = (int) $_SESSION['user_id'];
        $search = is_string($_GET['q'] ?? null) ? trim($_GET['q']) : '';
        $search = substr($search, 0, 120);
        $filter = is_string($_GET['status'] ?? null) ? $_GET['status'] : '';
        if ($filter !== '' && !isset(self::STATUSES[$filter])) {
            $filter = '';
        }
        $jobs = $this->jobs()->findAllForUser($userId, $filter, $search);
        $counts = $this->jobs()->countsForUser($userId);
        $flash = $_SESSION['jobs_flash'] ?? null;
        unset($_SESSION['jobs_flash']);
        $statuses = self::STATUSES;
        $this->render('index', compact('jobs', 'counts', 'flash', 'statuses', 'filter', 'search'));
    }

    private function create(): void
    {
        $flash = $this->pullForm();
        $old = $flash['old'];
        $errors = $flash['errors'];
        $statuses = self::STATUSES;
        $workModels = self::WORK_MODELS;
        $employmentTypes = self::EMPLOYMENT_TYPES;
        $this->render('create', compact('old', 'errors', 'statuses', 'workModels', 'employmentTypes'));
    }

    private function show(): void
    {
        $job = $this->getOwnedJob();
        $statuses = self::STATUSES;
        $flash = $_SESSION['jobs_flash'] ?? null;
        unset($_SESSION['jobs_flash']);
        $this->render('show', compact('job', 'statuses', 'flash'));
    }

    private function edit(): void
    {
        $job = $this->getOwnedJob();
        $flash = $this->pullForm();
        $old = $flash['old'] ? array_replace($job, $flash['old']) : $job;
        $errors = $flash['errors'];
        $statuses = self::STATUSES;
        $workModels = self::WORK_MODELS;
        $employmentTypes = self::EMPLOYMENT_TYPES;
        $this->render('edit', compact('job', 'old', 'errors', 'statuses', 'workModels', 'employmentTypes'));
    }

    private function store(): void
    {
        [$values, $errors, $old] = $this->validateForm();
        if ($errors) {
            $this->saveForm($errors, $old);
            $this->redirect('create');
        }
        $id = $this->jobs()->create((int) $_SESSION['user_id'], $values);
        $this->flash('success', 'Candidatura cadastrada com sucesso!');
        $this->redirect('show', $id);
    }

    private function update(): void
    {
        $job = $this->getOwnedJob();
        [$values, $errors, $old] = $this->validateForm();
        if ($errors) {
            $this->saveForm($errors, $old);
            $this->redirect('edit', (int) $job['id']);
        }
        $this->jobs()->update((int) $job['id'], (int) $_SESSION['user_id'], $values);
        $this->flash('success', 'Candidatura atualizada com sucesso!');
        $this->redirect('show', (int) $job['id']);
    }

    private function changeStatus(): void
    {
        $job = $this->getOwnedJob();
        $status = (string) ($_POST['status'] ?? '');
        if (!isset(self::STATUSES[$status])) {
            http_response_code(422);
            exit('Status inválido.');
        }
        $this->jobs()->updateStatus((int) $job['id'], (int) $_SESSION['user_id'], $status);
        $this->flash('success', 'Status atualizado!');
        $this->redirect('show', (int) $job['id']);
    }

    private function destroy(): void
    {
        $job = $this->getOwnedJob();
        $this->jobs()->delete((int) $job['id'], (int) $_SESSION['user_id']);
        $this->flash('success', 'Candidatura excluída.');
        $this->redirect('index');
    }

    private function getOwnedJob(): array
    {
        $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($id === false || $id === null) {
            $this->notFound();
        }
        $job = $this->jobs()->findForUser($id, (int) $_SESSION['user_id']);
        if (!$job) {
            // 404 impede também revelar se a candidatura pertence a outra conta.
            $this->notFound();
        }
        return $job;
    }

    private function validateForm(): array
    {
        $old = [];
        foreach (['company_name', 'job_title', 'location', 'work_model',
                  'employment_type', 'salary', 'job_url', 'status', 'applied_at', 'notes'] as $key) {
            $value = $_POST[$key] ?? '';
            $old[$key] = is_string($value) ? trim($value) : '';
        }

        $errors = [];
        foreach (['company_name' => 'Empresa', 'job_title' => 'Cargo'] as $key => $label) {
            if ($old[$key] === '' || strlen($old[$key]) > 150) {
                $errors[] = "$label é obrigatório e deve ter até 150 caracteres.";
            }
        }
        if (strlen($old['location']) > 150) {
            $errors[] = 'Localização deve ter até 150 caracteres.';
        }
        if ($old['work_model'] !== '' && !isset(self::WORK_MODELS[$old['work_model']])) {
            $errors[] = 'Modalidade inválida.';
        }
        if ($old['employment_type'] !== '' && !isset(self::EMPLOYMENT_TYPES[$old['employment_type']])) {
            $errors[] = 'Tipo de contrato inválido.';
        }
        if (!isset(self::STATUSES[$old['status']])) {
            $errors[] = 'Status inválido.';
        }
        if ($old['salary'] !== '' && !preg_match('/^\d{1,8}(?:\.\d{1,2})?$/', $old['salary'])) {
            $errors[] = 'Salário inválido. Use números com ponto decimal, por exemplo: 2500.00.';
        }
        if ($old['job_url'] !== '' && (
            strlen($old['job_url']) > 2048 ||
            !filter_var($old['job_url'], FILTER_VALIDATE_URL) ||
            !in_array(strtolower((string) parse_url($old['job_url'], PHP_URL_SCHEME)), ['http', 'https'], true)
        )) {
            $errors[] = 'Informe um link HTTP ou HTTPS válido.';
        }
        if ($old['notes'] !== '' && strlen($old['notes']) > 5000) {
            $errors[] = 'Observações devem ter até 5000 caracteres.';
        }
        if ($old['applied_at'] !== '') {
            $date = DateTimeImmutable::createFromFormat('!Y-m-d', $old['applied_at']);
            if (!$date || $date->format('Y-m-d') !== $old['applied_at']) {
                $errors[] = 'Data da candidatura inválida.';
            }
        }
        $values = [
            'company_name' => $old['company_name'],
            'job_title' => $old['job_title'],
            'location' => $old['location'] ?: null,
            'work_model' => $old['work_model'] ?: null,
            'employment_type' => $old['employment_type'] ?: null,
            'salary' => $old['salary'] === '' ? null : $old['salary'],
            'job_url' => $old['job_url'] ?: null,
            'status' => $old['status'],
            'applied_at' => $old['applied_at'] ?: null,
            'notes' => $old['notes'] ?: null,
        ];
        return [$values, $errors, $old];
    }

    private function saveForm(array $errors, array $old): void
    {
        $_SESSION['job_form'] = ['errors' => $errors, 'old' => $old];
    }

    private function pullForm(): array
    {
        $flash = $_SESSION['job_form'] ?? ['errors' => [], 'old' => []];
        unset($_SESSION['job_form']);
        return $flash;
    }

    private function flash(string $type, string $message): void
    {
        $_SESSION['jobs_flash'] = ['type' => $type, 'message' => $message];
    }

    private function render(string $view, array $vars): void
    {
        extract($vars, EXTR_SKIP);
        $page = 'jobs'; // Ativa o item correto na sidebar já existente.
        require __DIR__ . '/../../views/layouts/header.php';
        require __DIR__ . '/../../views/jobs/' . $view . '.php';
        require __DIR__ . '/../../views/layouts/footer.php';
    }

    private function redirect(string $action, ?int $id = null): never
    {
        $url = 'index.php?page=jobs';
        if ($action !== 'index') {
            $url .= '&action=' . rawurlencode($action);
        }
        if ($id !== null) {
            $url .= '&id=' . $id;
        }
        header('Location: ' . $url, true, 303);
        exit;
    }

    private function notFound(): never
    {
        http_response_code(404);
        exit('Candidatura não encontrada.');
    }

    private function methodNotAllowed(string $allowed): never
    {
        header('Allow: ' . $allowed);
        http_response_code(405);
        exit('Método não permitido.');
    }
}
