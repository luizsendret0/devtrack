
<?php

$page = $_GET['page'] ?? 'dashboard';

$routes = [
    'dashboard' => 'dashboard/index.php',
    'login' => 'auth/login.php',
    'register' => 'auth/register.php',

    // Páginas que serão desenvolvidas depois
    'jobs' => 'shared/coming-soon.php',
    'vacancies' => 'shared/coming-soon.php',
    'skills' => 'shared/coming-soon.php',
    'analytics' => 'shared/coming-soon.php',
    'goals' => 'shared/coming-soon.php',
    'studies' => 'shared/coming-soon.php',
    'trails' => 'shared/coming-soon.php',
    'contents' => 'shared/coming-soon.php',
    'exercises' => 'shared/coming-soon.php',
    'settings' => 'shared/coming-soon.php'
];

if (!isset($routes[$page])) {
    http_response_code(404);
    exit('Página não encontrada.');
}

$view = __DIR__ . '/../views/' . $routes[$page];

require __DIR__ . '/../views/layouts/header.php';
require $view;
require __DIR__ . '/../views/layouts/footer.php';
