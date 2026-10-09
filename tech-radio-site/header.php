<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/db/repository.php';
require_once __DIR__ . '/data/products.php';

// Подсчёт количества товаров в корзине
$cart_count = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_count += $item['qty'];
    }
}

$categoriesRows = tryGetCategories();
if (is_array($categoriesRows) && !empty($categoriesRows)) {
    $categories = [];
    foreach ($categoriesRows as $c) {
        $categories[(string)$c['alias']] = (string)$c['name'];
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechRadio | Каталог радиодеталей</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="main-header">
        <div class="container header-container">
            <a href="index.php" class="logo">
                <span class="logo-accent">Tech</span>Radio
            </a>
            <nav class="main-nav">
                <a href="index.php">Главная</a>
                <a href="catalog.php">Каталог</a>
                <a href="contacts.php">Контакты</a>
                <a href="cart.php" class="cart-link">
                     Корзина
                    <?php if ($cart_count > 0): ?>
                        <span class="cart-badge"><?= $cart_count ?></span>
                    <?php endif; ?>
                </a>
            </nav>
        </div>
    </header>
    <main class="container content">
