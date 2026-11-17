<?php

declare(strict_types=1);

class Job
{
    public function __construct(private PDO $pdo)
    {
    }

    public function findAllForUser(int $userId, string $status = '', string $query = ''): array
    {
        $sql = 'SELECT id, company_name, job_title, location, work_model, employment_type,
                       salary, job_url, status, applied_at, notes, created_at, updated_at
                FROM job_applications WHERE user_id = :user_id';
        $params = ['user_id' => $userId];

        if ($status !== '') {
            $sql .= ' AND status = :status';
            $params['status'] = $status;
        }
        if ($query !== '') {
            // Escapa % e _ para tratá-los como texto literal na pesquisa.
            $pattern = '%' . str_replace(['!', '%', '_'], ['!!', '!%', '!_'], $query) . '%';
            $sql .= " AND (company_name LIKE :company ESCAPE '!' OR job_title LIKE :title ESCAPE '!')";
            $params['company'] = $pattern;
            $params['title'] = $pattern;
        }

        $sql .= ' ORDER BY created_at DESC, id DESC LIMIT 100';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countsForUser(int $userId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT status, COUNT(*) AS quantity FROM job_applications
             WHERE user_id = :user_id GROUP BY status'
        );
        $stmt->execute(['user_id' => $userId]);
        $counts = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $counts[$row['status']] = (int) $row['quantity'];
        }
        return $counts;
    }

    public function findForUser(int $id, int $userId): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM job_applications WHERE id = :id AND user_id = :user_id LIMIT 1'
        );
        $stmt->execute(['id' => $id, 'user_id' => $userId]);
        $job = $stmt->fetch(PDO::FETCH_ASSOC);
        return $job ?: null;
    }

    public function create(int $userId, array $values): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO job_applications
             (user_id, company_name, job_title, location, work_model, employment_type,
              salary, job_url, status, applied_at, notes)
             VALUES
             (:user_id, :company_name, :job_title, :location, :work_model, :employment_type,
              :salary, :job_url, :status, :applied_at, :notes)'
        );
        $stmt->execute(['user_id' => $userId] + $values);
        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, int $userId, array $values): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE job_applications SET
                company_name = :company_name, job_title = :job_title,
                location = :location, work_model = :work_model,
                employment_type = :employment_type, salary = :salary,
                job_url = :job_url, status = :status,
                applied_at = :applied_at, notes = :notes
             WHERE id = :id AND user_id = :user_id'
        );
        $stmt->execute($values + ['id' => $id, 'user_id' => $userId]);
    }

    public function updateStatus(int $id, int $userId, string $status): void
    {
        $stmt = $this->pdo->prepare(
            "UPDATE job_applications
             SET status = :status,
                 applied_at = CASE
                     WHEN :is_applied = 1 AND applied_at IS NULL THEN CURRENT_DATE()
                     ELSE applied_at END
             WHERE id = :id AND user_id = :user_id"
        );
        $stmt->execute([
            'status' => $status,
            'is_applied' => $status === 'candidatado' ? 1 : 0,
            'id' => $id,
            'user_id' => $userId,
        ]);
    }

    public function delete(int $id, int $userId): void
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM job_applications WHERE id = :id AND user_id = :user_id'
        );
        $stmt->execute(['id' => $id, 'user_id' => $userId]);
    }
}
