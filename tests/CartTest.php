<?php

use PHPUnit\Framework\TestCase;
use jregner\ShopBase\Cart;
use jregner\ShopBase\Product;
use jregner\ShopBase\Types\Price;

class CartTest extends TestCase
{
    /** @var Cart */
    protected $cart;

    protected function setUp(): void
    {
        $products = [
            new Product('0', 'Product Number 0', new Price(1200, 'EUR')),
            new Product('1', 'Product Number 1', new Price(2400, 'EUR')),
            new Product('2', 'Product Number 2', new Price(50, 'EUR')),
            new Product('3', 'Product Number 3', new Price(10000000, 'EUR')),
        ];

        $cart = new Cart();
        $count = count($products);
        for ($i = 0; $i < $count; ++$i) {
            $cart->add($products[$i]->toArticle(), $i + 1);
        }

        $this->cart = $cart;
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(
            Cart::class,
            new Cart()
        );
    }

    public function testGet()
    {
        $cart = new Cart();

        $this->assertEquals(
            [],
            $cart->get()->toArray()
        );
    }

    public function testAdd()
    {
        $cart = new Cart();
        $product = new Product('1234', 'Product Number 1234', new Price(1200, 'EUR'));

        $article = $product->toArticle();
        $cart->add($article, 2);

        $this->assertEquals(
            [
                '1234' => $article->setAmount(2),
            ],
            $cart->get()->toArray()
        );
    }

    public function testRemove()
    {
        $cart = new Cart();
        $product = new Product('1234', 'Product Number 1234', new Price(1200, 'EUR'));

        $cart->add($product->toArticle(), 2);

        $cart->remove('1234');

        $this->assertEquals(
            [],
            $cart->get()->toArray()
        );
    }

    public function testRaiseAmount()
    {
        $cart = new Cart();
        $product = new Product('1234', 'Product Number 1234', new Price(1200, 'EUR'));

        $cart->add($product->toArticle());

        $cart->raiseAmount($product->getArticleNumber());

        $this->assertEquals(
            2,
            $cart->get()->toArray()[$product->getArticleNumber()]->getAmount()
        );
    }

    public function testReduceAmount()
    {
        $cart = new Cart();
        $product = new Product('1234', 'Product Number 1234', new Price(1200, 'EUR'));

        $cart->add($product->toArticle(), 2);

        $cart->reduceAmount($product->getArticleNumber());

        $this->assertEquals(
            1,
            $cart->get()->toArray()[$product->getArticleNumber()]->getAmount()
        );
    }

    public function testClear()
    {
        $cart = new Cart();
        $product = new Product('1234', 'Product Number 1234', new Price(1200, 'EUR'));

        $cart->add($product->toArticle());

        $cart->clear();

        $this->assertEquals(
            [],
            $cart->get()->toArray()
        );
    }

    public function testGetSum()
    {
        $this->assertEquals(
            new Price(40006150, 'EUR'),
            $this->cart->getSum()
        );
    }
}
