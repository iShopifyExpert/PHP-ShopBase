<?php

use PHPUnit\Framework\TestCase;
use jregner\ShopBase\Article;
use jregner\ShopBase\Product;
use jregner\ShopBase\Types\Price;
use jregner\ShopBase\Interfaces\IToArticle;
use jregner\ShopBase\Interfaces\IProduct;

class ProductTest extends TestCase
{
    /** @var Product */
    protected $product;

    protected function setUp(): void
    {
        $this->product = new Product('ArticleNumber', 'ProductName', new Price(1200, 'EUR'));
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(
            Product::class,
            $this->product
        );

        $this->assertInstanceOf(
            IProduct::class,
            $this->product
        );

        $this->assertInstanceOf(
            IToArticle::class,
            $this->product
        );
    }

    public function testGetArticleNumber()
    {
        $this->assertEquals(
            'ArticleNumber',
            $this->product->getArticleNumber()
        );
    }

    public function testGetName()
    {
        $this->assertEquals(
            'ProductName',
            $this->product->getName()
        );
    }

    public function testSetName()
    {
        $this->product->setName('NameOfProduct');

        $this->assertEquals(
            'NameOfProduct',
            $this->product->getName()
        );
    }

    public function testGetPrice()
    {
        $this->assertEquals(
            1200,
            $this->product->getPrice()->getValue()
        );

        $this->assertEquals(
            'EUR',
            $this->product->getPrice()->getCurrency()
        );
    }

    public function testSetPrice()
    {
        $this->product->setPrice(new Price(2400, 'EUR'));

        $this->assertEquals(
            2400,
            $this->product->getPrice()->getValue()
        );

        $this->assertEquals(
            'EUR',
            $this->product->getPrice()->getCurrency()
        );
    }

    public function testGetDescription()
    {
        $this->assertEquals(
            null,
            $this->product->getDescription()
        );
    }

    public function testSetDescription()
    {
        $this->product->setDescription('This is an awesome product description');

        $this->assertEquals(
            'This is an awesome product description',
            $this->product->getDescription()
        );
    }

    public function testGetStock()
    {
        $this->assertEquals(
            null,
            $this->product->getStock()
        );
    }

    public function testSetStock()
    {
        $this->product->setStock(100);

        $this->assertEquals(
            100,
            $this->product->getStock()
        );
    }

    public function testGetCategories()
    {
        $this->assertEquals(
            [],
            $this->product->getCategories()->toArray()
        );
    }

    public function testSetCategories()
    {
        $this->product->setCategories([
            'My Category One',
            'My Category Two',
        ]);

        $this->assertEquals(
            [
                'My Category One',
                'My Category Two',
            ],
            $this->product->getCategories()->toArray()
        );
    }

    public function testAddCategory()
    {
        $this->product->setCategories([
            'My Category One',
            'My Category Two',
        ]);

        $this->product->addCategory('My Category Three');

        $this->assertEquals(
            [
                'My Category One',
                'My Category Two',
                'My Category Three',
            ],
            $this->product->getCategories()->toArray()
        );
    }

    public function testHasCategory()
    {
        $this->product->setCategories([
            'My Category One',
        ]);

        $this->assertTrue(
            $this->product->hasCategory('My Category One')
        );

        $this->assertFalse(
            $this->product->hasCategory('My Category Two')
        );
    }

    public function testRemoveCategory()
    {
        $this->product->setCategories([
            'My Category One',
            'My Category Two',
        ]);

        $this->product->removeCategory('My Category One');

        $this->assertEquals(
            [
                1 => 'My Category Two',
            ],
            $this->product->getCategories()->toArray()
        );
    }

    public function testToArticle()
    {
        $article = new Article('ArticleNumber', new Price(1200, 'EUR'));

        $this->assertEquals(
            $article,
            $this->product->toArticle()
        );
    }
}
