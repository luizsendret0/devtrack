<?php

declare(strict_types=1);

/**
 * Consultas de leitura do dashboard.
 * Todo acesso a candidaturas é filtrado pelo id da sessão.
 */
final class DashboardStats
{
    private const GROUPS = [
        ['key' => 'salva', 'label' => 'Salvas', 'statuses' => ['salva']],
        ['key' => 'candidatado', 'label' => 'Candidatadas', 'statuses' => ['candidatado']],
        ['key' => 'entrevista', 'label' => 'Entrevistas', 'statuses' => ['entrevista']],
        ['key' => 'aprovado', 'label' => 'Aprovadas', 'statuses' => ['aprovado']],
        ['key' => 'encerradas', 'label' => 'Encerradas', 'statuses' => ['recusado', 'desistiu']],
    ];

    public function __construct(private PDO $pdo)
    {
    }

    public function forUser(int $userId): array
    {
        // Contadores completos, sem o limite usado para exibir cartões.
        $stmt = $this->pdo->prepare(
            'SELECT status, COUNT(*) AS total
             FROM job_applications
             WHERE user_id = :user_id
             GROUP BY status'
        );
        $stmt->execute(['user_id' => $userId]);

        $counts = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $counts[(string) $row['status']] = (int) $row['total'];
        }

        $columns = [];
        foreach (self::GROUPS as $group) {
            // Carrega todas as vagas para que qualquer cartão possa ser movido no Kanban.
            $params = ['user_id' => $userId];
            $placeholders = [];
            foreach ($group['statuses'] as $i => $status) {
                $name = 'status_' . $i;
                $placeholders[] = ':' . $name;
                $params[$name] = $status;
            }

            $sql = 'SELECT id, company_name, job_title, work_model, status, created_at
                    FROM job_applications
                    WHERE user_id = :user_id
                    AND status IN (' . implode(', ', $placeholders) . ')
                    ORDER BY created_at DESC, id DESC';
            $itemsStmt = $this->pdo->prepare($sql);
            $itemsStmt->execute($params);

            $count = 0;
            foreach ($group['statuses'] as $status) {
                $count += $counts[$status] ?? 0;
            }

            $columns[] = [
                'key' => $group['key'],
                'label' => $group['label'],
                'count' => $count,
                'jobs' => $itemsStmt->fetchAll(PDO::FETCH_ASSOC),
                'filter' => count($group['statuses']) === 1 ? $group['statuses'][0] : null,
            ];
        }

        return [
            'total' => array_sum($counts),
            'applied' => $counts['candidatado'] ?? 0,
            'interviews' => $counts['entrevista'] ?? 0,
            'approved' => $counts['aprovado'] ?? 0,
            'closed' => ($counts['recusado'] ?? 0) + ($counts['desistiu'] ?? 0),
            'columns' => $columns,
        ];
    }
}
