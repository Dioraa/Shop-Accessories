<?php
class Product {
    public function __construct(private PDO $pdo) {}

    public function latest(int $limit = 8): array {
        $limit = max(1, min($limit, 50));
        $stmt = $this->pdo->query("
            SELECT p.*, c.name AS category_name
            FROM products p
            JOIN categories c ON c.id = p.category_id
            ORDER BY p.created_at DESC
            LIMIT $limit
        ");
        return $stmt->fetchAll();
    }

    public function all(?int $categoryId = null, string $search = ""): array {
        $sql = "SELECT p.*, c.name AS category_name
                FROM products p JOIN categories c ON c.id = p.category_id
                WHERE 1=1";
        $params = [];

        if ($categoryId) {
            $sql .= " AND p.category_id = ?";
            $params[] = $categoryId;
        }
        if ($search !== "") {
            $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }

        $sql .= " ORDER BY p.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array {
        $stmt = $this->pdo->prepare("
            SELECT p.*, c.name AS category_name
            FROM products p JOIN categories c ON c.id = p.category_id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        $product = $stmt->fetch();
        return $product ?: null;
    }
}
