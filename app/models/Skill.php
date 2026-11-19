<?php

declare(strict_types=1);

/**
 * Tecnologias exigidas pelas candidaturas.
 * A tecnologia e global; todo acesso a vagas/estatisticas e limitado ao usuario.
 */
final class Skill
{
    public function __construct(private PDO $pdo)
    {
    }

    /** @return array{0: array<string>, 1: array<string>} */
    public static function parseInput(string $text): array
    {
        $errors = [];
        if (strlen($text) > 1500) {
            return [[], ['O campo tecnologias pode ter ate 1500 caracteres.']];
        }
        $parts = preg_split('/[,;\r\n]+/u', $text);
        if ($parts === false) {
            return [[], ['Texto de tecnologias invalido.']];
        }
        $items = [];
        $seen = [];
        foreach ($parts as $part) {
            $normalized = preg_replace('/\s+/u', ' ', trim($part));
            if (!is_string($normalized)) {
                return [[], ['Texto de tecnologias invalido.']];
            }
            if ($normalized === '') {
                continue;
            }
            $length = function_exists('mb_strlen') ? mb_strlen($normalized, 'UTF-8') : strlen($normalized);
            if ($length > 60) {
                $errors[] = 'Cada tecnologia deve ter no maximo 60 caracteres.';
                continue;
            }
            if (!preg_match('/^[\p{L}\p{N} .+#\/_-]+$/u', $normalized)) {
                $errors[] = 'Use somente letras, numeros, espacos e os simbolos . + # / _ - nas tecnologias.';
                continue;
            }
            $key = function_exists('mb_strtolower') ? mb_strtolower($normalized, 'UTF-8') : strtolower($normalized);
            if (!isset($seen[$key])) {
                $seen[$key] = true;
                $items[] = $normalized;
            }
        }
        if (count($items) > 15) {
            $errors[] = 'Informe no maximo 15 tecnologias por candidatura.';
        }
        return [$errors ? [] : $items, array_values(array_unique($errors))];
    }

    /**
     * Troca a lista de tecnologias de UMA candidatura pertencente ao usuario.
     * Deve ser executado dentro da mesma transacao da criacao/edicao da vaga.
     * @param list<string> $names
     */
    public function replaceForJob(int $jobId, int $userId, array $names): void
    {
        $stmt = $this->pdo->prepare('SELECT id FROM job_applications WHERE id = :id AND user_id = :user_id LIMIT 1 FOR UPDATE');
        $stmt->execute(['id' => $jobId, 'user_id' => $userId]);
        if ($stmt->fetchColumn() === false) {
            throw new RuntimeException('Candidatura nao encontrada.');
        }

        $delete = $this->pdo->prepare('DELETE FROM job_skills WHERE job_id = :job_id');
        $delete->execute(['job_id' => $jobId]);
        $skillInsert = $this->pdo->prepare(
            'INSERT INTO skills (name) VALUES (:name) ON DUPLICATE KEY UPDATE id = LAST_INSERT_ID(id)'
        );
        $linkInsert = $this->pdo->prepare(
            'INSERT INTO job_skills (job_id, skill_id) VALUES (:job_id, :skill_id)'
        );
        $usedIds = [];
        foreach ($names as $name) {
            $skillInsert->execute(['name' => $name]);
            $skillId = (int) $this->pdo->lastInsertId();
            if (isset($usedIds[$skillId])) {
                continue; // MySQL trata caixa/acento conforme a collation da coluna.
            }
            $usedIds[$skillId] = true;
            $linkInsert->execute(['job_id' => $jobId, 'skill_id' => $skillId]);
        }
    }

    /** @return list<string> */
    public function namesForJob(int $jobId, int $userId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT s.name FROM skills s
             INNER JOIN job_skills js ON js.skill_id = s.id
             INNER JOIN job_applications j ON j.id = js.job_id
             WHERE j.id = :id AND j.user_id = :user_id
             ORDER BY s.name'
        );
        $stmt->execute(['id' => $jobId, 'user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /** @return array<int, list<string>> */
    public function namesForJobs(int $userId, array $jobIds): array
    {
        $jobIds = array_values(array_unique(array_filter(array_map('intval', $jobIds), static fn($id) => $id > 0)));
        if (!$jobIds) {
            return [];
        }
        $placeholders = implode(', ', array_fill(0, count($jobIds), '?'));
        $stmt = $this->pdo->prepare(
            "SELECT j.id AS job_id, s.name
             FROM job_applications j
             INNER JOIN job_skills js ON js.job_id = j.id
             INNER JOIN skills s ON s.id = js.skill_id
             WHERE j.user_id = ? AND j.id IN ($placeholders)
             ORDER BY s.name"
        );
        $stmt->execute([$userId, ...$jobIds]);
        $result = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $result[(int) $row['job_id']][] = (string) $row['name'];
        }
        return $result;
    }

    /** @return array<int, array{name:string, total:int}> */
    public function rankingForUser(int $userId, int $limit = 6): array
    {
        $limit = max(1, min($limit, 30));
        $stmt = $this->pdo->prepare(
            'SELECT s.name, COUNT(*) AS total
             FROM job_applications j
             INNER JOIN job_skills js ON js.job_id = j.id
             INNER JOIN skills s ON s.id = js.skill_id
             WHERE j.user_id = :user_id
             GROUP BY s.id, s.name
             ORDER BY total DESC, s.name ASC
             LIMIT ' . $limit
        );
        $stmt->execute(['user_id' => $userId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(static fn(array $r): array => ['name' => (string) $r['name'], 'total' => (int) $r['total']], $rows);
    }
}
