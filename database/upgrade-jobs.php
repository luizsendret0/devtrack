<?php
// DevTrack v0.4.0-alpha — migração segura (execute SOMENTE via terminal: php database/upgrade-jobs.php)
// Preserva os dados. Nunca usa DROP TABLE nem recria a tabela users.
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Execute esta migração pelo terminal.');
}

try {
    $pdo = require __DIR__ . '/../app/config/database.php';
    if (!$pdo instanceof PDO) {
        throw new RuntimeException('app/config/database.php precisa retornar um objeto PDO.');
    }

    $tableExists = static function (string $name) use ($pdo): bool {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM information_schema.TABLES
            WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table');
        $stmt->execute(['table' => $name]);
        return (int) $stmt->fetchColumn() > 0;
    };

    if (!$tableExists('users')) {
        throw new RuntimeException('A tabela users ainda não existe. Configure a autenticação primeiro.');
    }

    $userId = $pdo->query("SHOW COLUMNS FROM users LIKE 'id'")->fetch(PDO::FETCH_ASSOC);
    if (!$userId || stripos((string) $userId['Type'], 'int') === false) {
        throw new RuntimeException('O campo users.id precisa ser um inteiro. Revise a estrutura antes de executar.');
    }
    // Descobre o tipo real da PK de users para criar uma FK compatível com INT/BIGINT e sinal.
    $type = (string) $userId['Type'];
    if (!preg_match('/^(?:bigint|int|mediumint|smallint|tinyint)(?:\(\d+\))?\s*(?:unsigned)?$/i', $type)) {
        throw new RuntimeException('Tipo de users.id não reconhecido: ' . $type);
    }

    if (!$tableExists('job_applications')) {
        $pdo->exec("CREATE TABLE job_applications (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id $type NOT NULL,
            company_name VARCHAR(150) NOT NULL,
            job_title VARCHAR(150) NOT NULL,
            location VARCHAR(150) NULL,
            work_model VARCHAR(20) NULL,
            employment_type VARCHAR(25) NULL,
            salary DECIMAL(10,2) NULL,
            job_url VARCHAR(2048) NULL,
            status VARCHAR(30) NOT NULL DEFAULT 'salva',
            applied_at DATE NULL,
            notes TEXT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_jobs_user_status (user_id, status),
            INDEX idx_jobs_user_date (user_id, created_at),
            CONSTRAINT fk_jobs_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        echo "[OK] Tabela job_applications criada.\n";
    } else {
        echo "[OK] Tabela job_applications já existia. Conferindo colunas...\n";
        $columns = $pdo->query('SHOW COLUMNS FROM job_applications')->fetchAll(PDO::FETCH_COLUMN);
        foreach (['id', 'user_id', 'company_name', 'job_title'] as $required) {
            if (!in_array($required, $columns, true)) {
                throw new RuntimeException("Campo essencial '$required' não encontrado. Faça um backup e revise a tabela manualmente.");
            }
        }
        $optional = [
            'location' => 'VARCHAR(150) NULL',
            'work_model' => 'VARCHAR(20) NULL',
            'employment_type' => 'VARCHAR(25) NULL',
            'salary' => 'DECIMAL(10,2) NULL',
            'job_url' => 'VARCHAR(2048) NULL',
            'status' => "VARCHAR(30) NOT NULL DEFAULT 'salva'",
            'applied_at' => 'DATE NULL',
            'notes' => 'TEXT NULL',
            'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ];
        foreach ($optional as $column => $definition) {
            if (!in_array($column, $columns, true)) {
                // Colunas e definições são constantes internas, sem entrada externa.
                $pdo->exec("ALTER TABLE job_applications ADD COLUMN `$column` $definition");
                echo "[OK] Coluna '$column' adicionada.\n";
            }
        }
        $indexes = $pdo->query('SHOW INDEX FROM job_applications')->fetchAll(PDO::FETCH_ASSOC);
        $indexNames = array_column($indexes, 'Key_name');
        if (!in_array('idx_jobs_user_status', $indexNames, true)) {
            $pdo->exec('CREATE INDEX idx_jobs_user_status ON job_applications (user_id, status)');
            echo "[OK] Índice idx_jobs_user_status criado.\n";
        }
        if (!in_array('idx_jobs_user_date', $indexNames, true)) {
            $pdo->exec('CREATE INDEX idx_jobs_user_date ON job_applications (user_id, created_at)');
            echo "[OK] Índice idx_jobs_user_date criado.\n";
        }
        $constraint = $pdo->query("SELECT COUNT(*) FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'job_applications'
              AND COLUMN_NAME = 'user_id' AND REFERENCED_TABLE_NAME = 'users'")->fetchColumn();
        if (!(int) $constraint) {
            echo "[ATENÇÃO] A tabela existente não tem FK user_id -> users.id. Não adicionamos automaticamente\n";
            echo "          para evitar falhas em bases com dados antigos. Revise isso antes do deploy.\n";
        }
    }
    echo "[OK] Migração concluída sem remover dados.\n";
} catch (Throwable $error) {
    fwrite(STDERR, '[ERRO] ' . $error->getMessage() . "\n");
    exit(1);
}
