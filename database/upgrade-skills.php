<?php
/**
 * DevTrack v0.6.0-beta: adiciona tabelas de tecnologias sem alterar ou apagar vagas.
 * Execute somente por terminal: php database/upgrade-skills.php
 */
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Execute esta migracao pelo terminal.');
}

try {
    $pdo = require __DIR__ . '/../app/config/database.php';
    if (!$pdo instanceof PDO) {
        throw new RuntimeException('app/config/database.php precisa retornar PDO.');
    }
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare('SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :name');
    $tableExists = static function (string $name) use ($stmt): bool {
        $stmt->execute(['name' => $name]);
        return (int) $stmt->fetchColumn() > 0;
    };

    if (!$tableExists('job_applications')) {
        throw new RuntimeException('Tabela job_applications nao encontrada. Execute o CRUD de vagas primeiro.');
    }
    $columns = $pdo->query('SHOW COLUMNS FROM job_applications')->fetchAll(PDO::FETCH_ASSOC);
    $idColumn = null;
    foreach ($columns as $column) {
        if ($column['Field'] === 'id') {
            $idColumn = $column;
            break;
        }
    }
    if (!$idColumn || (string) $idColumn['Key'] !== 'PRI') {
        throw new RuntimeException('job_applications.id precisa ser chave primaria.');
    }
    $jobIdType = (string) $idColumn['Type'];
    if (!preg_match('/^(?:bigint|int|mediumint|smallint|tinyint)(?:\(\d+\))?(?:\s+unsigned)?$/i', $jobIdType)) {
        throw new RuntimeException('Tipo de ID da vaga nao suportado: ' . $jobIdType);
    }

    if (!$tableExists('skills')) {
        $pdo->exec("CREATE TABLE skills (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(60) COLLATE utf8mb4_unicode_ci NOT NULL,
            UNIQUE KEY uq_skills_name (name)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        echo "[OK] Tabela skills criada.\n";
    } else {
        $cols = $pdo->query('SHOW COLUMNS FROM skills')->fetchAll(PDO::FETCH_COLUMN);
        if (!in_array('id', $cols, true) || !in_array('name', $cols, true)) {
            throw new RuntimeException('Tabela skills existente possui estrutura inesperada. Revise manualmente.');
        }
        echo "[OK] Tabela skills ja existe.\n";
    }

    if (!$tableExists('job_skills')) {
        $pdo->exec("CREATE TABLE job_skills (
            job_id $jobIdType NOT NULL,
            skill_id INT UNSIGNED NOT NULL,
            PRIMARY KEY (job_id, skill_id),
            INDEX idx_job_skills_skill (skill_id),
            CONSTRAINT fk_job_skills_job FOREIGN KEY (job_id) REFERENCES job_applications(id) ON DELETE CASCADE,
            CONSTRAINT fk_job_skills_skill FOREIGN KEY (skill_id) REFERENCES skills(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        echo "[OK] Tabela job_skills criada.\n";
    } else {
        $cols = $pdo->query('SHOW COLUMNS FROM job_skills')->fetchAll(PDO::FETCH_COLUMN);
        if (!in_array('job_id', $cols, true) || !in_array('skill_id', $cols, true)) {
            throw new RuntimeException('Tabela job_skills existente possui estrutura inesperada. Revise manualmente.');
        }
        echo "[OK] Tabela job_skills ja existe.\n";
    }
    echo "[OK] Migracao de tecnologias concluida. Nenhuma candidatura foi apagada.\n";
} catch (Throwable $e) {
    fwrite(STDERR, '[ERRO] ' . $e->getMessage() . "\n");
    exit(1);
}
