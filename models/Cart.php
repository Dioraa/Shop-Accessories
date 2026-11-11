<?php
class Cart {
    public function __construct(private PDO $pdo) {}

    public function items(int $userId): array {
        $stmt = $this->pdo->prepare("
            SELECT c.id AS cart_id, c.quantity,
                   p.id AS product_id, p.name, p.price, p.image, p.stock
            FROM cart c
            JOIN products p ON p.id = c.product_id
            WHERE c.user_id = ?
            ORDER BY c.id DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function add(int $userId, int $productId, int $quantity = 1): void {
        $quantity = max(1, $quantity);
        $stmt = $this->pdo->prepare("
            INSERT INTO cart (user_id, product_id, quantity)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)
        ");
        $stmt->execute([$userId, $productId, $quantity]);
    }

    public function update(int $userId, int $cartId, int $quantity): void {
        if ($quantity <= 0) {
            $this->remove($userId, $cartId);
            return;
        }
        $stmt = $this->pdo->prepare("UPDATE cart SET quantity=? WHERE id=? AND user_id=?");
        $stmt->execute([$quantity, $cartId, $userId]);
    }

    public function remove(int $userId, int $cartId): void {
        $stmt = $this->pdo->prepare("DELETE FROM cart WHERE id=? AND user_id=?");
        $stmt->execute([$cartId, $userId]);
    }

    public function clear(int $userId): void {
        $stmt = $this->pdo->prepare("DELETE FROM cart WHERE user_id=?");
        $stmt->execute([$userId]);
    }
}
