<?php
require_once "config/database.php";
require_once "config/auth.php";
require_once "config/helpers.php";
requireLogin();

$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$orders = $stmt->fetchAll();

$pageTitle = "Orders | Classy";
require "partials/header.php";
?>
<section class="page-banner compact">
    <span class="eyebrow">YOUR ACCOUNT</span>
    <h1>Orders</h1>
</section>
<section class="section">
    <?php if (isset($_GET['success'])): ?><div class="success">Your order has been placed successfully.</div><?php endif; ?>
    <?php if (!$orders): ?>
        <div class="empty-state"><h2>No orders yet</h2><p>Your purchases will appear here.</p><a class="btn" href="products.php">Start shopping</a></div>
    <?php else: ?>
        <div class="orders">
        <?php foreach ($orders as $order): ?>
            <div class="order-card">
                <div><small>Order #<?= e($order['id']) ?></small><h3>€<?= number_format($order['total'],2) ?></h3></div>
                <span class="status"><?= e($order['status']) ?></span>
                <small><?= e($order['created_at']) ?></small>
            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
<?php require "partials/footer.php"; ?>
