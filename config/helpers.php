<?php
function e($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $url): void {
    header("Location: $url");
    exit;
}

function cartCount(PDO $pdo): int {
    if (!isset($_SESSION['user_id'])) return 0;
    $stmt = $pdo->prepare("SELECT COALESCE(SUM(quantity),0) FROM cart WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return (int)$stmt->fetchColumn();
}
