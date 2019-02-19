# PHP ShopBase
[![Build Status](https://travis-ci.org/Tera3yte/PHP-ShopBase.svg?branch=master)](https://travis-ci.org/Tera3yte/PHP-ShopBase)
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
### API
#### Interfaces
##### IArticle
```php
public function getArticleNumber(): string;
public function setAmount(int $amount): self;
public function getAmount(): int;
public function getSum(): Price;
```
##### ICart
```php
public function get(): ArrayCollection;
public function clear(): void;
```
##### IOrder
```php

```

##### IProduct
```php
public function getArticleNumber(): string;
public function setStock(int $stock): self;
public function getStock(): ?int;
```
##### IToArticle
```php
public function toArticle(): IArticle;
```
#### Types
##### Price
Methods
```php
public function __construct(int $value, string $currency)
public function getValue(): int
public function getCurrency(): string
public function format($locale, $style = \NumberFormatter::CURRENCY): string
```
Usage
```php
$price = new Price(1200, 'EUR');
$price->getValue() // 1200
$price->getCurrency() // EUR
$price->format('de') // 12,00 €

// ---
$price = new Price(1200, 'ALIEN_CURRENCY') // throws InvalidCurrencyException
```
#### Base
##### Article
Methods
```php
public function __construct(string $articleNumber, Price $price)
public static function fromProduct(IToArticle $product): IArticle
public function getArticleNumber(): string
public function setAmount(int $amount): IArticle
public function getAmount(): int
public function setPrice(Price $price): IArticle
public function getPrice(): Price
public function getSum(): Price
```
Usage
```php
$article = new Article('1234', $price);
$article = Article::fromProduct($product);
$article->getArticleNumber(); // 1234
$article->setAmount(2);
$article->getAmount(); // 2 (default: 1)
$article->setPrice(new Price(1200, 'EUR'));
$article->getPrice(); // returns Price
$article->getSum(); // returns amount * price

// ---
$article->setAmount(-2) // values lower than 1 will result in amount = 1
$article->getAmount() // 1 (default: 1)
```
##### Cart
Methods
```php
public function add(IArticle $article, int $amount = null): self
public function remove(string $articleNumber): self
public function get(): ArrayCollection
public function raiseAmount(string $articleNumber): self
public function reduceAmount(string $articleNumber): self
public function clear(): void
public function getSum(): Price
```
Usage
```php
$cart = new Cart();
$cart->add($article, 2); // add article 2 times to cart
$cart->remove('1234'); // remove article with article number 1234
$cart->get(); // get all cart articles
$cart->raiseAmount('1234'); // raise amount of article 1234 by 1
$cart->reduceAmount('1234'); // reduce amount of article 1234 by 1 (if 0 article will be removed)
$cart->clear(); // clear cart
$cart->getSum(); // returns cart sum (call on each article getSum())

// --- Parameter 'amount' will overwrite article amount!
$article = new Article('1234', $price);
$cart->add($article); // amount = 1
$cart->add($article, 2); // amount = 2
$article->setAmount(5);
$cart->add($article) // amount = 5
$cart->add($article, 10) // amount = 10
```
