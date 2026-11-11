<?php
require_once "../config/database.php";
require_once "../config/auth.php";
require_once "../config/helpers.php";
requireLogin();

if ($_SESSION['user_id'] !== 1) {
    http_response_code(403);
    die("Admin access required.");
}

$products = $pdo->query("SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON c.id=p.category_id ORDER BY p.id DESC")->fetchAll();
$orders = $pdo->query("SELECT COUNT(*) AS count, COALESCE(SUM(total),0) AS revenue FROM orders")->fetch();
$users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$pageTitle = "Admin | Classy";
require "../partials/header.php";
?>
<section class="page-banner compact">
    <span class="eyebrow">ADMIN PANEL</span>
    <h1>Store overview</h1>
</section>
<section class="section">
    <div class="stats">
        <div><small>Products</small><strong><?= count($products) ?></strong></div>
        <div><small>Orders</small><strong><?= e($orders['count']) ?></strong></div>
        <div><small>Revenue</small><strong>€<?= number_format($orders['revenue'],2) ?></strong></div>
        <div><small>Users</small><strong><?= e($users) ?></strong></div>
    </div>
    <div class="admin-table">
        <div class="table-head"><span>Product</span><span>Category</span><span>Price</span><span>Stock</span></div>
        <?php foreach ($products as $product): ?>
            <div class="table-row">
                <span><?= e($product['name']) ?></span>
                <span><?= e($product['category_name']) ?></span>
                <span>€<?= number_format($product['price'],2) ?></span>
                <span><?= e($product['stock']) ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require "../partials/footer.php"; ?>
