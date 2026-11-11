<?php
require_once "config/database.php";
require_once "config/auth.php";
require_once "config/helpers.php";
require_once "models/Cart.php";

requireLogin();
$cart = new Cart($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $productId = (int)($_POST['product_id'] ?? 0);
    $cartId = (int)($_POST['cart_id'] ?? 0);

    if ($action === 'add' && $productId) {
        $cart->add($_SESSION['user_id'], $productId, (int)($_POST['quantity'] ?? 1));
    } elseif ($action === 'update' && $cartId) {
        $cart->update($_SESSION['user_id'], $cartId, (int)($_POST['quantity'] ?? 1));
    } elseif ($action === 'remove' && $cartId) {
        $cart->remove($_SESSION['user_id'], $cartId);
    } elseif ($action === 'clear') {
        $cart->clear($_SESSION['user_id']);
    }
    header("Location: cart.php");
    exit;
}

$items = $cart->items($_SESSION['user_id']);
$total = 0;
foreach ($items as $item) $total += $item['price'] * $item['quantity'];

$pageTitle = "Shopping Bag | VELORA";
require "partials/header.php";
?>
<section class="page-banner compact">
    <span class="eyebrow">YOUR BAG</span>
    <h1>Shopping bag</h1>
</section>
<section class="section cart-layout">
    <div>
        <?php if (!$items): ?>
            <div class="empty-state"><h2>Your bag is empty</h2><p>Add something beautiful to get started.</p><a class="btn" href="products.php">Continue shopping</a></div>
        <?php else: ?>
            <?php foreach ($items as $item): ?>
            <div class="cart-item">
                <img src="public/images/<?= e($item['image']) ?>" alt="<?= e($item['name']) ?>">
                <div class="cart-item-info">
                    <small><?= e($item['name']) ?></small>
                    <strong>€<?= number_format($item['price'], 2) ?></strong>
                    <form method="post" class="quantity-form">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="cart_id" value="<?= e($item['cart_id']) ?>">
                        <input type="number" name="quantity" value="<?= e($item['quantity']) ?>" min="1" max="<?= e($item['stock']) ?>">
                        <button>Update</button>
                    </form>
                </div>
                <form method="post">
                    <input type="hidden" name="action" value="remove">
                    <input type="hidden" name="cart_id" value="<?= e($item['cart_id']) ?>">
                    <button class="remove-btn">Remove</button>
                </form>
            </div>
            <?php endforeach; ?>
            <form method="post"><input type="hidden" name="action" value="clear"><button class="text-button">Clear bag</button></form>
        <?php endif; ?>
    </div>
    <?php if ($items): ?>
    <aside class="summary">
        <h2>Summary</h2>
        <div><span>Subtotal</span><strong>€<?= number_format($total, 2) ?></strong></div>
        <div><span>Shipping</span><strong>Free</strong></div>
        <hr>
        <div class="total"><span>Total</span><strong>€<?= number_format($total, 2) ?></strong></div>
        <a class="btn full" href="checkout.php">Checkout →</a>
    </aside>
    <?php endif; ?>
</section>
<?php require "partials/footer.php"; ?>
