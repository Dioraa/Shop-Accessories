<?php
class Category {
    public function __construct(private PDO $pdo) {}

    public function all(): array {
        return $this->pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
    }
}
