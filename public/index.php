<?php
// PONTO DE ENTRADA DO DEVTRACK
// Esta versão adiciona a landing sem usar o layout do dashboard.
// Se seu public/index.php tem rotas extras, mantenha-as no array abaixo.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = $_GET['page'] ?? 'landing';

// Páginas públicas com layout próprio.
if ($page === 'landing') {
    require __DIR__ . '/../views/layouts/landing-header.php';
    require __DIR__ . '/../views/landing/index.php';
    require __DIR__ . '/../views/layouts/landing-footer.php';
    exit;
}

// As rotas já existentes no projeto continuam aqui.
$routes = [
    'dashboard' => 'dashboard/index.php',
    'login' => 'auth/login.php',
    'register' => 'auth/register.php',
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

if (!array_key_exists($page, $routes)) {
    http_response_code(404);
    exit('Página não encontrada.');
}

// Quando o login for implementado, proteger estas rotas com middleware.
// NÃO considere a presença da rota como controle de acesso.
$view = __DIR__ . '/../views/' . $routes[$page];

require __DIR__ . '/../views/layouts/header.php';
require $view;
require __DIR__ . '/../views/layouts/footer.php';
