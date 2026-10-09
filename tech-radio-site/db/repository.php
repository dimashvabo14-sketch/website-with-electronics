<?php
declare(strict_types=1);

require_once __DIR__ . '/pdo.php';

function getCategories(): array
{
    $stmt = pdo()->query('SELECT id, alias, name FROM categories ORDER BY name');
    return $stmt->fetchAll();
}

function tryGetCategories(): ?array
{
    try {
        return getCategories();
    } catch (\PDOException $e) {
        return null;
    }
}

function getCategoryByAlias(string $alias): ?array
{
    $stmt = pdo()->prepare('SELECT id, alias, name FROM categories WHERE alias = ? LIMIT 1');
    $stmt->execute([$alias]);
    $row = $stmt->fetch();
    return $row ? $row : null;
}

function tryGetCategoryByAlias(string $alias): ?array
{
    try {
        return getCategoryByAlias($alias);
    } catch (\PDOException $e) {
        return null;
    }
}

function getProducts(?int $categoryId = null): array
{
    if ($categoryId === null) {
        $stmt = pdo()->query('
            SELECT p.id, p.category_id, c.alias, p.name, p.price_byn, p.description
            FROM products p
            INNER JOIN categories c ON c.id = p.category_id
            ORDER BY p.id
        ');
    } else {
        $stmt = pdo()->prepare('
            SELECT p.id, p.category_id, c.alias, p.name, p.price_byn, p.description
            FROM products p
            INNER JOIN categories c ON c.id = p.category_id
            WHERE p.category_id = ?
            ORDER BY p.id
        ');
        $stmt->execute([$categoryId]);
    }

    $rows = $stmt->fetchAll();

    $result = [];
    foreach ($rows as $r) {
        $result[(int)$r['id']] = [
            'id' => (int)$r['id'],
            'category_id' => (int)$r['category_id'],
            'category' => (string)$r['alias'],
            'name' => (string)$r['name'],
            'price' => (float)$r['price_byn'],
            'desc' => (string)($r['description'] ?? ''),
            'variants' => [],
        ];
    }

    return $result;
}

function tryGetProducts(?int $categoryId = null): ?array
{
    try {
        return getProducts($categoryId);
    } catch (\PDOException $e) {
        return null;
    }
}

function getProductVariants(int $productId): array
{
    $stmt = pdo()->prepare('SELECT variant_text FROM product_variants WHERE product_id = ? ORDER BY id');
    $stmt->execute([$productId]);
    return array_map(fn($x) => (string)$x['variant_text'], $stmt->fetchAll());
}

function tryGetProductById(int $productId): ?array
{
    try {
        $stmt = pdo()->prepare('
            SELECT p.id, p.category_id, p.name, p.price_byn, p.description, c.alias AS category_alias
            FROM products p
            INNER JOIN categories c ON c.id = p.category_id
            WHERE p.id = ?
            LIMIT 1
        ');
        $stmt->execute([$productId]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return [
            'id' => (int)$row['id'],
            'category' => (string)$row['category_alias'],
            'name' => (string)$row['name'],
            'price' => (float)$row['price_byn'],
            'desc' => (string)($row['description'] ?? ''),
            'variants' => getProductVariants((int)$row['id']),
        ];
    } catch (\PDOException $e) {
        return null;
    }
}
