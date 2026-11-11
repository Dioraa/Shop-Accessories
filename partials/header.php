<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/helpers.php';
$cartItemsCount = isset($pdo) ? cartCount($pdo) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'classy') ?></title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
<header class="navbar">
    <a class="logo" href="index.php">Classy</a>
    <nav class="desktop-nav">
        <a href="index.php">Home</a>
        <a href="products.php">Shop</a>
        <a href="products.php?category=1">Jewelry</a>
        <a href="products.php?category=3">Eyewear</a>
        <a href="products.php?category=4">Bags</a>
    </nav>
    <div class="nav-actions">
        <?php if (isLoggedIn()): ?>
            <a href="orders.php">Orders</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
        <a class="cart-link" href="cart.php">Bag <span><?= $cartItemsCount ?></span></a>
        <button class="mobile-menu" aria-label="Open menu">☰</button>
    </div>
</header>
<main>
