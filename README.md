# PHP ShopBase
[![codecov](https://codecov.io/gh/Tera3yte/PHP-ShopBase/branch/master/graph/badge.svg)](https://codecov.io/gh/Tera3yte/PHP-ShopBase)

This is a simple library for setting up a shop in PHP. You can use the classes as they are or extend from them to easily form the shop as you need it.
## Usage
### Installation
```bash
composer require jregner/php-shopbase
```
### Test
```bash
git clone https://github.com/Tera3yte/PHP-ShopBase.git
composer install
composer test
```

## Documentation
### Examples
#### Basic Usage
```php
$products = [
	new Product('1234', 'Product 1234', new Price(1200, 'EUR'));
	new Product('5678', 'Product 5678', new Price(2400, 'EUR'));
];

$p1 = $products[0]->addCategory('ABC')->addCategory('ABC 123');
$p2 = $products[1]->addCategory('DEF')->setDescription('Product 5678 is awesome');

$shop = new Shop($products);

$shop->updateProduct($p1->getArticleNumber(), $p1);
$shop->updateProduct('5678', $p2);

$shop->addProduct(new Product('9101', 'Product 9101', new Price('50', 'EUR')));

$shop->getProducts();
```
