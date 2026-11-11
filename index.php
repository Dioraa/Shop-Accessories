<?php
require_once "config/database.php";
require_once "config/auth.php";
require_once "config/helpers.php";
require_once "models/Product.php";
require_once "models/Category.php";

$productModel = new Product($pdo);
$categoryModel = new Category($pdo);
$products = $productModel->latest(8);
$categories = $categoryModel->all();
$pageTitle = "Classy | Accessories";
require "partials/header.php";
?>
<section class="hero">
    <div class="hero-content">
        <span class="eyebrow">NEW COLLECTION — 2026</span>
        <h1>Accessories that <em>define you.</em></h1>
        <p>Discover jewelry, watches, eyewear and bags curated for your everyday style.</p>
        <a class="btn btn-light" href="products.php">Shop collection <span>→</span></a>
    </div>
</section>

<section class="section">
    <div class="section-head">
        <div><span class="eyebrow">EXPLORE</span><h2>Shop by category</h2></div>
        <a class="text-link" href="products.php">View all →</a>
    </div>
    <div class="category-grid">
        <?php foreach ($categories as $category): ?>
            <a class="category-card category-<?= e($category['id']) ?>" href="products.php?category=<?= e($category['id']) ?>">
                <div>
                    <span><?= str_pad((string)$category['id'], 2, '0', STR_PAD_LEFT) ?></span>
                    <h3><?= e($category['name']) ?></h3>
                </div>
                <span>Explore →</span>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<section class="section section-muted">
    <div class="section-head">
        <div><span class="eyebrow">CURATED FOR YOU</span><h2>New arrivals</h2></div>
        <a class="text-link" href="products.php">Shop all →</a>
    </div>
    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <article class="product-card">
                <a href="product.php?id=<?= e($product['id']) ?>">
                    <div class="product-image">
                        <img src="public/images/<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>">
                        <span class="product-tag">NEW</span>
                    </div>
                    <div class="product-info">
                        <small><?= e($product['category_name']) ?></small>
                        <h3><?= e($product['name']) ?></h3>
                        <strong>€<?= number_format($product['price'], 2) ?></strong>
                    </div>
                </a>
                <?php if (isLoggedIn()): ?>
                <form action="cart.php" method="post">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" value="<?= e($product['id']) ?>">
                    <button class="add-btn" type="submit">Add to bag</button>
                </form>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="promo">
    <div>
        <span class="eyebrow">CLASSY EDIT</span>
        <h2>Small details.<br><em>Big impression.</em></h2>
    </div>
    <a class="btn" href="products.php">Discover the edit →</a>
</section>
<?php require "partials/footer.php"; ?>
