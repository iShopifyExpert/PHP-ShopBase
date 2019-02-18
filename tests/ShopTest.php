<?php

use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\ArrayCollection;
use jregner\ShopBase\Shop;
use jregner\ShopBase\Cart;
use jregner\ShopBase\Product;
use jregner\ShopBase\Article;
use jregner\ShopBase\Types\Price;
use jregner\ShopBase\Exceptions\Product\ProductAlreadyExistsException;

class ShopTest extends TestCase
{
    /** @var Shop */
    protected $shop;
    protected $products;

    protected function setUp(): void
    {
        $products = [];

        for ($i = 0; $i <= 10; ++$i) {
            $tempProduct = new Product(
                (string) $i,
                'Product Number ' . $i,
                new Price($i * 2000, 'EUR')
            );

            $tempProduct->setStock($i * 5);
            $tempProduct->setDescription('Product Description No ' . $i);
            $tempProduct->setCategories([
                'Products',
                'Product ' . $i,
            ]);

            $products[] = $tempProduct;
        }

        $this->products = $products;
        $this->shop = new Shop(new ArrayCollection($products));
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(
            Shop::class,
            $this->shop
        );
    }

    public function testGetProducts()
    {
        $this->assertEquals(
            $this->products,
            $this->shop->getProducts()->toArray()
        );
    }

    public function testSetProducts()
    {
        $products = [
            new Product('0', 'Product Number 0', new Price(0, 'EUR')),
        ];

        $this->shop->setProducts(new ArrayCollection($products));

        $this->assertEquals(
            $products,
            $this->shop->getProducts()->toArray()
        );
    }

    public function testGetProduct()
    {
        $this->assertEquals(
            $this->products[0],
            $this->shop->getProduct('0')
        );
    }

    public function testAddProduct()
    {
        $product = new Product('11', 'Product Number 11', new Price(1200, 'EUR'));

        $this->shop->addProduct($product);

        $this->assertEquals(
            $product,
            $this->shop->getProduct($product->getArticleNumber())
        );
    }

    public function testAddProductWithAlreadyExistingProduct()
    {
        $this->expectException(ProductAlreadyExistsException::class);

        $this->shop->addProduct(new Product('0', 'Product Number 0', new Price(1200, 'EUR')));
    }

    public function testHasProduct()
    {
        $this->assertTrue(
            $this->shop->hasProduct('0')
        );

        $this->assertFalse(
            $this->shop->hasProduct('11')
        );
    }

    public function testRemoveProduct()
    {
        $this->shop->removeProduct('0');

        unset($this->products['0']);

        $this->assertEquals(
            $this->products,
            $this->shop->getProducts()->toArray()
        );
    }

    public function testCheckout()
    {
        $cart = new Cart();

        $article = new Article('0', new Price(0, 'EUR'));

        $cart->add($article, 5);

        $order = $this->shop->checkout($cart);

        $this->assertEquals(
            -5,
            $this->shop->getProduct('0')->getStock()
        );

        $this->assertEquals(
            [],
            $cart->get()->toArray()
        );

        $this->assertEquals(
            $cart->get(),
            $order->getArticles()
        );
    }
}
