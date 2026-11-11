<?php
class User {
    public function __construct(private PDO $pdo) {}

    public function findByEmail(string $email): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function create(string $name, string $email, string $password): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO users (name,email,password) VALUES (?,?,?)"
        );
        return $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
    }
}
