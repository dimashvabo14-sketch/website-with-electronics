<?php
declare(strict_types=1);

include 'header.php';
require_once __DIR__ . '/db/repository.php';

$current_cat = $_GET['cat'] ?? null;
$sort_by = $_GET['sort'] ?? 'default';

$filtered_products = [];
$page_title = 'Все товары';

require_once __DIR__ . '/data/products.php';

// Пытаемся взять данные из БД, если MySQL недоступна — используем статику
$categoryRow = null;
if (is_string($current_cat) && $current_cat !== '') {
    $categoryRow = tryGetCategoryByAlias($current_cat);
}

if ($categoryRow) {
    $dbProducts = tryGetProducts((int)$categoryRow['id']);
    if (is_array($dbProducts)) {
        $filtered_products = $dbProducts;
        $page_title = (string)$categoryRow['name'];
    }
} else {
    if (is_string($current_cat) && $current_cat !== '') {
        $page_title = $categories[$current_cat] ?? 'Все товары';
        $filtered_products = array_filter(
            $products,
            fn($p) => isset($p['category']) && $p['category'] === $current_cat
        );
    } else {
        $filtered_products = $products;
    }
}

// Сортировка
$sort_options = [
    'default' => 'По умолчанию',
    'price_asc' => 'Цена (по возрастанию)',
    'price_desc' => 'Цена (по убыванию)',
    'name_asc' => 'Название (А-Я)',
    'name_desc' => 'Название (Я-А)',
];

if ($sort_by === 'price_asc') {
    usort($filtered_products, fn($a, $b) => $a['price'] <=> $b['price']);
} elseif ($sort_by === 'price_desc') {
    usort($filtered_products, fn($a, $b) => $b['price'] <=> $a['price']);
} elseif ($sort_by === 'name_asc') {
    usort($filtered_products, fn($a, $b) => $a['name'] <=> $b['name']);
} elseif ($sort_by === 'name_desc') {
    usort($filtered_products, fn($a, $b) => $b['name'] <=> $a['name']);
}
?>

<div class="catalog-header">
    <h1 class="section-title"><?= htmlspecialchars($page_title) ?></h1>
    <div class="catalog-controls">
        <?php if ($current_cat): ?>
            <a href="catalog.php" class="btn-outline">Сбросить фильтр</a>
        <?php endif; ?>
        <form method="GET" class="sort-form">
            <?php if ($current_cat): ?>
                <input type="hidden" name="cat" value="<?= htmlspecialchars($current_cat) ?>">
            <?php endif; ?>
            <label for="sort">Сортировка:</label>
            <select name="sort" id="sort" onchange="this.form.submit()">
                <?php foreach ($sort_options as $key => $label): ?>
                    <option value="<?= $key ?>" <?= $sort_by === $key ? 'selected' : '' ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>
</div>

<div class="products-grid">
    <?php if (empty($filtered_products)): ?>
        <p>В данной категории нет товаров.</p>
    <?php else: ?>
        <?php foreach ($filtered_products as $item): ?>
            <div class="product-card">
                <div class="product-img-placeholder">
                    <img
                        src="<?= $item['image'] ?>"
                        alt="<?= htmlspecialchars($item['name']) ?>"
                        style="width:100%; height:100%; object-fit:contain;"
                    />
                </div>
                <div class="product-info">
                    <span class="product-category"><?= $categories[$item['category']] ?></span>
                    <h3 class="product-title"><?= htmlspecialchars($item['name']) ?></h3>
                    <div class="product-price">от <?= $item['price'] ?> BYN</div>
                    <div class="product-card-actions">
                        <a href="product.php?id=<?= $item['id'] ?>" class="btn">Подробнее</a>
                        <a href="add_to_cart.php?id=<?= $item['id'] ?>" class="btn-outline btn-sm">В корзину</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
