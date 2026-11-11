<?php
require_once "config/database.php";
require_once "config/auth.php";
require_once "config/helpers.php";
require_once "models/Product.php";

$id = (int)($_GET['id'] ?? 0);
$product = (new Product($pdo))->find($id);
if (!$product) { http_response_code(404); die("Product not found."); }

$pageTitle = $product['name'] . " | Classy";
require "partials/header.php";
?>
<section class="product-detail section">
    <div class="detail-image">
        <img src="public/images/<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>">
    </div>
    <div class="detail-content">
        <span class="eyebrow"><?= e($product['category_name']) ?></span>
        <h1><?= e($product['name']) ?></h1>
        <div class="detail-price">€<?= number_format($product['price'], 2) ?></div>
        <p><?= e($product['description']) ?></p>
        <div class="stock"><?= (int)$product['stock'] > 0 ? 'In stock' : 'Out of stock' ?></div>
        <?php if (isLoggedIn() && (int)$product['stock'] > 0): ?>
        <form class="buy-form" action="cart.php" method="post">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="product_id" value="<?= e($product['id']) ?>">
            <label>Quantity <input type="number" name="quantity" value="1" min="1" max="<?= e($product['stock']) ?>"></label>
            <button class="btn" type="submit">Add to bag →</button>
        </form>
        <?php elseif (!isLoggedIn()): ?>
            <a class="btn" href="login.php">Login to purchase →</a>
        <?php endif; ?>
    </div>
</section>
<?php require "partials/footer.php"; ?>
