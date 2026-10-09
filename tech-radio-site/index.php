<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/data/products.php';
include 'header.php'; ?>

<section class="hero">
    <h1>Оборудование для связи и электроники</h1>
    <p>Надежные антенны, кабели, усилители и комплектующие промышленного качества.</p>
</section>

<h2 class="section-title">Категории товаров</h2>
<div class="categories-grid">
    <?php foreach ($categories as $alias => $name): ?>
        <a href="catalog.php?cat=<?= $alias ?>" class="category-card">
            <div class="cat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
            </div>
            <h3><?= $name ?></h3>
        </a>
    <?php endforeach; ?>
</div>

<h2 class="section-title">Популярные товары</h2>
<div class="products-grid">
    <?php foreach (array_slice($products, 0, 4) as $item): ?>
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
                <a href="product.php?id=<?= $item['id'] ?>" class="btn">Подробнее</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'footer.php'; ?>