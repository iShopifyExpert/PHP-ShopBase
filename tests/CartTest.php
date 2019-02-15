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
            $cart->add($products[$i], $i + 1);
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

    public function testGetSum()
    {
        $this->assertEquals(
            40006150,
            $this->cart->getSum()->getValue()
        );

        $this->assertEquals(
            'EUR',
            $this->cart->getSum()->getCurrency()
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

        $cart->add($product, 2);

        $this->assertEquals(
            [
                '1234' => [
                    'amount' => 2,
                    'product' => $product,
                ],
            ],
            $cart->get()->toArray()
        );
    }

    public function testRemove()
    {
        $cart = new Cart();
        $product = new Product('1234', 'Product Number 1234', new Price(1200, 'EUR'));

        $cart->add($product, 2);

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

        $cart->add($product);

        $cart->raiseAmount($product->getArticleNumber());

        $this->assertEquals(
            [
                '1234' => [
                    'amount' => 2,
                    'product' => $product,
                ],
            ],
            $cart->get()->toArray()
        );
    }

    public function testReduceAmount()
    {
        $cart = new Cart();
        $product = new Product('1234', 'Product Number 1234', new Price(1200, 'EUR'));

        $cart->add($product, 2);

        $cart->reduceAmount($product->getArticleNumber());

        $this->assertEquals(
            [
                '1234' => [
                    'amount' => 1,
                    'product' => $product,
                ],
            ],
            $cart->get()->toArray()
        );
    }

    public function testCheckout()
    {
        $data = $this->cart->checkout();

        $this->assertEquals(
            [
                '0' => 1,
                '1' => 2,
                '2' => 3,
                '3' => 4,
            ],
            $data->toArray()
        );

        $this->assertEquals(
            [],
            $this->cart->get()->toArray()
        );
    }
}
