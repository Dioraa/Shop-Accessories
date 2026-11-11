<?php
require_once "config/database.php";
require_once "config/auth.php";
require_once "config/helpers.php";
require_once "models/Cart.php";

requireLogin();
$cart = new Cart($pdo);
$items = $cart->items($_SESSION['user_id']);
if (!$items) redirect("products.php");

$total = 0;
foreach ($items as $item) $total += $item['price'] * $item['quantity'];

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("INSERT INTO orders (user_id,total,status) VALUES (?,?, 'pending')");
        $stmt->execute([$_SESSION['user_id'], $total]);
        $orderId = (int)$pdo->lastInsertId();

        $itemStmt = $pdo->prepare("INSERT INTO order_items (order_id,product_id,quantity,price) VALUES (?,?,?,?)");
        $stockStmt = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id=? AND stock >= ?");
        foreach ($items as $item) {
            $itemStmt->execute([$orderId, $item['product_id'], $item['quantity'], $item['price']]);
            $stockStmt->execute([$item['quantity'], $item['product_id'], $item['quantity']]);
            if ($stockStmt->rowCount() === 0) throw new Exception("One product is out of stock.");
        }

        $cart->clear($_SESSION['user_id']);
        $pdo->commit();
        redirect("orders.php?success=1");
    } catch (Throwable $e) {
        $pdo->rollBack();
        $error = "Checkout failed. Please try again.";
    }
}

$pageTitle = "Checkout | VELORA";
require "partials/header.php";
?>
<section class="page-banner compact">
    <span class="eyebrow">SECURE CHECKOUT</span>
    <h1>Complete your order</h1>
</section>
<section class="section checkout-layout">
    <form method="post" class="checkout-form">
        <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
        <h2>Shipping details</h2>
        <label>Full name<input required name="name" autocomplete="name"></label>
        <label>Email<input required type="email" name="email" autocomplete="email"></label>
        <label>Address<input required name="address" autocomplete="street-address"></label>
        <div class="two-col">
            <label>City<input required name="city"></label>
            <label>Postal code<input required name="postal_code"></label>
        </div>
        <button class="btn full" type="submit">Place order — €<?= number_format($total, 2) ?></button>
    </form>
    <aside class="summary">
        <h2>Your order</h2>
        <?php foreach ($items as $item): ?>
            <div><span><?= e($item['name']) ?> × <?= e($item['quantity']) ?></span><strong>€<?= number_format($item['price']*$item['quantity'],2) ?></strong></div>
        <?php endforeach; ?>
        <hr><div class="total"><span>Total</span><strong>€<?= number_format($total,2) ?></strong></div>
    </aside>
</section>
<?php require "partials/footer.php"; ?>
