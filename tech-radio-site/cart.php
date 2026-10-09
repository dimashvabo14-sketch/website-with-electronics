<?php
declare(strict_types=1);
include 'header.php';
require_once __DIR__ . '/data/products.php';

$action = $_GET['action'] ?? null;
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Инициализация корзины
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Удалить товар из корзины
if ($action === 'remove' && $id !== null && isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]);
    header('Location: cart.php');
    exit;
}

// Очистить корзину
if ($action === 'clear') {
    $_SESSION['cart'] = [];
    header('Location: cart.php');
    exit;
}

$cart_items = $_SESSION['cart'];
$total_price = 0;
?>

<h1 class="section-title">Корзина</h1>

<?php if (empty($cart_items)): ?>
    <div class="cart-empty">
        <p>Корзина пуста.</p>
        <a href="catalog.php" class="btn">Перейти в каталог</a>
    </div>
<?php else: ?>
    <div class="cart-table">
        <div class="cart-header">
            <span class="cart-col-img">Товар</span>
            <span class="cart-col-name">Наименование</span>
            <span class="cart-col-price">Цена</span>
            <span class="cart-col-qty">Кол-во</span>
            <span class="cart-col-total">Сумма</span>
            <span class="cart-col-action"></span>
        </div>
        <?php foreach ($cart_items as $item_id => $item):
            $item_total = $item['price'] * $item['qty'];
            $total_price += $item_total;
        ?>
            <div class="cart-row">
                <div class="cart-col-img">
                    <img src="<?= $item['image'] ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width:60px;height:60px;object-fit:contain;background:#171717;border-radius:4px;" />
                </div>
                <div class="cart-col-name">
                    <a href="product.php?id=<?= $item_id ?>"><?= htmlspecialchars($item['name']) ?></a>
                </div>
                <div class="cart-col-price"><?= $item['price'] ?> BYN</div>
                <div class="cart-col-qty"><?= (int)$item['qty'] ?></div>
                <div class="cart-col-total"><?= number_format($item_total, 2) ?> BYN</div>
                <div class="cart-col-action">
                    <a href="cart.php?action=remove&id=<?= $item_id ?>" class="btn-remove" onclick="return confirm('Удалить товар из корзины?')">✕</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="cart-footer">
        <div class="cart-total">
            <span class="cart-total-label">Общая стоимость:</span>
            <span class="cart-total-value"><?= number_format($total_price, 2) ?> BYN</span>
        </div>
        <div class="cart-actions">
            <a href="cart.php?action=clear" class="btn-outline" onclick="return confirm('Очистить корзину?')">Очистить корзину</a>
            <button class="btn btn-large" onclick="alert('Заказ оформлен! Спасибо за покупку.'); window.location.href='cart.php?action=clear';">Оформить заказ</button>
        </div>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>