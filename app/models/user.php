<?php
class User
{
    public function __construct(private PDO $pdo) {}

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, name, email, password FROM users WHERE email = :email LIMIT 1'
        );
        $stmt->execute(['email' => $email]);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        return $record ?: null;
    }

    public function create(string $name, string $email, string $passwordHash): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)'
        );
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $passwordHash,
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function updatePasswordHash(int $id, string $hash): void
    {
        $stmt = $this->pdo->prepare('UPDATE users SET password = :password WHERE id = :id');
        $stmt->execute(['password' => $hash, 'id' => $id]);
    }
}
