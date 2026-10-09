SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS techradio
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE techradio;

DROP TABLE IF EXISTS product_variants;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE categories (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  alias VARCHAR(64) NOT NULL,
  name VARCHAR(128) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uk_categories_alias (alias)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE products (
  id INT UNSIGNED NOT NULL,
  category_id INT UNSIGNED NOT NULL,
  name VARCHAR(255) NOT NULL,
  price_byn DECIMAL(10,2) NOT NULL,
  description TEXT,
  PRIMARY KEY (id),
  KEY idx_products_category (category_id),
  CONSTRAINT fk_products_category
    FOREIGN KEY (category_id) REFERENCES categories(id)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE product_variants (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  product_id INT UNSIGNED NOT NULL,
  variant_text VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  KEY idx_variants_product (product_id),
  CONSTRAINT fk_variants_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO categories (id, alias, name) VALUES
  (1, 'antennas', 'Антенны'),
  (2, 'amplifiers', 'Усилители'),
  (3, 'power_supplies', 'Блоки питания'),
  (4, 'plugs', 'Штекеры'),
  (5, 'cables', 'Кабели');

INSERT INTO products (id, category_id, name, price_byn, description) VALUES
  -- Антенны
  (1, 1, 'Наружная с усилителем', 53.00, 'Высококачественная наружная антенна с интегрированным усилителем сигнала.'),
  (2, 1, 'Наружная без усилителя', 29.00, 'Пассивная наружная антенна для зон с уверенным приемом.'),
  (3, 1, 'Комнатная', 18.00, 'Компактная комнатная антенна.'),
  (4, 1, 'Автомобильная с усилителем', 43.00, 'Автомобильная антенна с магнитным основанием и усилителем.'),

  -- Усилители
  (5, 2, 'Усилитель (Сильный)', 22.00, 'Усилитель с высоким коэффициентом усиления для дальнего приема.'),
  (6, 2, 'Усилитель (Средний)', 15.00, 'Стандартный усилитель для большинства задач.'),
  (7, 2, 'Усилитель (Слабый)', 8.00, 'Усилитель для незначительной коррекции сигнала.'),
  (8, 2, 'Пустышка (без усиления)', 2.00, 'Согласующее устройство без активного усиления (плата-пустышка).'),

  -- Блоки питания
  (9, 3, 'БП с регулятором напряжения', 13.00, 'Блок питания с возможностью плавной регулировки напряжения.'),
  (10, 3, 'БП Стандартный', 9.00, 'Стандартный стабилизированный блок питания 12V.'),

  -- Штекеры
  (11, 4, 'Штекеры для блоков питания', 2.00, 'Набор стандартных штекеров для подключения БП к антеннам.'),

  -- Кабели
  (12, 5, 'Кабель для антенны (Коаксиальный)', 2.00, 'Высокочастотный коаксиальный кабель для передачи ТВ и радио сигнала.'),
  (13, 5, 'Кабель двухжильный', 1.00, 'Кабель для передачи питания и низкочастотных сигналов.'),
  (14, 5, 'Кабель одножильный', 1.00, 'Монтажный одножильный кабель.'),
  (15, 5, 'Кабель микрофонный', 2.00, 'Экранированный микрофонный кабель высокого качества.');

INSERT INTO product_variants (product_id, variant_text) VALUES
  -- product 12
  (12, '75 Ом: 690'),
  (12, '75 Ом: 48'),
  (12, '50 Ом'),

  -- product 13
  (13, '0.20 мм'),
  (13, '0.35 мм'),
  (13, '0.50 мм'),
  (13, '0.75 мм'),
  (13, '1.0 мм'),
  (13, '1.5 мм'),
  (13, '2.5 мм'),

  -- product 14
  (14, '0.35 мм'),
  (14, '0.50 мм'),
  (14, '1.0 мм'),
  (14, '1.5 мм'),
  (14, '2.5 мм'),
  (14, '4.0 мм');
