<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/DashboardStats.php';
require_once __DIR__ . '/../models/Skill.php';

final class DashboardController
{
    public function index(): void
    {
        // O roteador já executa auth.php; esta checagem é uma proteção extra.
        $userId = $_SESSION['user_id'] ?? null;
        if (!is_int($userId) || $userId <= 0) {
            redirect_to('login');
        }

        try {
            $pdo = require __DIR__ . '/../config/database.php';
            if (!$pdo instanceof PDO) {
                throw new RuntimeException('A configuração do banco deve retornar um PDO.');
            }
            $dashboard = (new DashboardStats($pdo))->forUser($userId);
            $skillRanking = (new Skill($pdo))->rankingForUser($userId, 6);
        } catch (PDOException $exception) {
            error_log('[DevTrack dashboard] ' . $exception->getMessage());
            http_response_code(500);
            exit('Não foi possível carregar o dashboard. Verifique o MySQL e tente novamente.');
        }

        $page = 'dashboard'; // Destaca o item correto da sidebar existente.
        require __DIR__ . '/../../views/layouts/header.php';
        require __DIR__ . '/../../views/dashboard/index.php';
        require __DIR__ . '/../../views/layouts/footer.php';
    }
}
