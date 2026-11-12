<?php
require_once "config/database.php";
require_once "config/auth.php";
require_once "config/helpers.php";
require_once "models/Product.php";
require_once "models/Category.php";

$productModel = new Product($pdo);
$categoryModel = new Category($pdo);
$categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;
$search = trim($_GET['search'] ?? '');
$products = $productModel->all($categoryId, $search);
$categories = $categoryModel->all();
$pageTitle = "Shop | Classy";
require "partials/header.php";
?>

<section class="pagee-banner">
    <img 
        src="/accessories-shop/public/images/banner.png" 
        alt="Collection Banner"
        style="width: 100%; height: 510px; object-fit: cover; object-position: center; display: block;"
    >
</section>
<section class="section">
    <div class="shop-toolbar">
        <div class="filters">
            <a class="<?= !$categoryId ? 'active' : '' ?>" href="products.php">All</a>
            <?php foreach ($categories as $category): ?>
                <a class="<?= $categoryId === (int)$category['id'] ? 'active' : '' ?>"
                   href="products.php?category=<?= e($category['id']) ?>">
                    <?= e($category['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
        <form class="search-form" method="get">
            <?php if ($categoryId): ?><input type="hidden" name="category" value="<?= e($categoryId) ?>"><?php endif; ?>
            <input type="search" name="search" value="<?= e($search) ?>" placeholder="Search products...">
            <button type="submit">Search</button>
        </form>
    </div>

    <?php if (!$products): ?>
        <div class="empty-state"><h2>No products found</h2><p>Try another search or category.</p></div>
    <?php else: ?>
    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <article class="product-card">
                <a href="product.php?id=<?= e($product['id']) ?>">
                    <div class="product-image">
                        <img src="public/images/<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>">
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
    <?php endif; ?>
</section>
<?php require "partials/footer.php"; ?>
