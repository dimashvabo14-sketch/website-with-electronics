<?php
declare(strict_types=1);

include 'header.php';
require_once __DIR__ . '/db/repository.php';
require_once __DIR__ . '/data/products.php';

$id = $_GET['id'] ?? null;

$product = null;

if (is_numeric($id)) {
    $product = tryGetProductById((int)$id);
}
// если БД недоступна/не найдено — берём из статических данных
if (!$product && is_numeric($id) && isset($products[(int)$id])) {
    $p = $products[(int)$id];
    $product = [
        'id' => (int)$p['id'],
        'category' => (string)$p['category'], 
        'name' => (string)$p['name'],
        'price' => (float)$p['price'],
        'desc' => (string)($p['desc'] ?? ''),
        'image' => (string)($p['image'] ?? ''),
        'variants' => isset($p['variants']) ? (array)$p['variants'] : [],
    ];
}

if (!$product) {
    echo "<h1>Товар не найден</h1>";
    include 'footer.php';
    exit;
}
?>

<div class="product-page">
    <div class="product-gallery">
        <?php if (!empty($product['image'])): ?>
            <div class="product-img-large">
                <img
                    src="<?= $product['image'] ?>"
                    alt="<?= htmlspecialchars($product['name']) ?>"
                    style="width:100%; height:100%; object-fit:contain;"
                />
            </div>
        <?php else: ?>
            <div class="product-img-large">
                <svg viewBox="0 0 100 100" fill="none" stroke="#555" stroke-width="2">
                    <rect x="10" y="10" width="80" height="80" rx="10" stroke-dasharray="5 5" />
                    <path d="M50 20 L50 80 M20 50 L80 50" opacity="0.3"/>
                    <circle cx="50" cy="50" r="20" fill="#222" stroke="#FF8C00"/>
                    <text x="50%" y="55%" dominant-baseline="middle" text-anchor="middle" fill="#777" font-size="10" font-family="sans-serif">NO IMAGE</text>
                </svg>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="product-details">
        <div class="breadcrumbs">
            <a href="catalog.php">Каталог</a> /
            <a href="catalog.php?cat=<?= $product['category'] ?>"><?= $categories[$product['category']] ?? $product['category'] ?></a>
        </div>
        
        <h1><?= htmlspecialchars($product['name']) ?></h1>
        <p class="product-desc"><?= htmlspecialchars($product['desc']) ?></p>
        
        <div class="price-block">
            <span class="price-label">Цена:</span>
            <span class="price-value"><?= $product['price'] ?> BYN</span>
        </div>

        <?php if (!empty($product['variants'])): ?>
            <div class="product-variants">
                <h3>Спецификация (выберите параметр):</h3>
                <div class="variants-grid">
                    <?php foreach ($product['variants'] as $index => $variant): ?>
                        <label class="variant-tile">
                            <input type="radio" name="variant" value="<?= $index ?>" <?= $index === 0 ? 'checked' : '' ?>>
                            <span class="variant-inner"><?= htmlspecialchars($variant) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <a href="add_to_cart.php?id=<?= $product['id'] ?>" class="btn btn-large">Добавить в корзину</a>
    </div>
</div>

<?php include 'footer.php'; ?>
