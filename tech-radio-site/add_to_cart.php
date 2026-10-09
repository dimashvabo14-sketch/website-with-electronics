<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/data/products.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$qty = isset($_GET['qty']) ? max(1, (int)$_GET['qty']) : 1;

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($id > 0 && isset($products[$id])) {
    $p = $products[$id];

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['qty'] += $qty;
    } else {
        $_SESSION['cart'][$id] = [
            'name' => $p['name'],
            'price' => $p['price'],
            'image' => $p['image'] ?? '',
            'qty' => $qty,
        ];
    }
}

header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'catalog.php'));
exit;