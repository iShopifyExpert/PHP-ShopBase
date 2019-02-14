# PHP ShopBase
This is a simple library for setting up a shop in PHP. You can use the classes as they are or extend from them to easily form the shop as you need it.
## Installation
`composer require jregner/php-shopbase`

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

$shop->addProduct(new Product('9101', 'Product 9101', new Price('50', 'EUR')));

$shop->getProducts();
```
