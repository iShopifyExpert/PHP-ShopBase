<?php

use PHPUnit\Framework\TestCase;
use jregner\ShopBase\Article;
use jregner\ShopBase\Product;
use jregner\ShopBase\Types\Price;
use jregner\ShopBase\Interfaces\IArticle;

class ArticleTest extends TestCase
{
    private $product;

    protected function setUp(): void
    {
        $this->product = new Product('1234', 'Product A', new Price(1200, 'EUR'));
    }

    public function testConstruct()
    {
        $article = new Article($this->product, 1);

        $this->assertInstanceOf(
            Article::class,
            $article
        );

        $this->assertInstanceOf(
            IArticle::class,
            $article
        );
    }

    public function testGetProduct()
    {
        $article = new Article($this->product, 1);

        $this->assertEquals(
            $this->product,
            $article->getProduct()
        );
    }

    public function testGetAmount()
    {
        $article = new Article($this->product, 1);

        $this->assertEquals(
            1,
            $article->getAmount()
        );
    }

    public function testSetAmount()
    {
        $article = new Article($this->product, 1);

        $article->setAmount(2);

        $this->assertEquals(
            2,
            $article->getAmount()
        );
    }

    public function testIncrementAmount()
    {
        $article = new Article($this->product, 1);

        $article->incrementAmount();

        $this->assertEquals(
            2,
            $article->getAmount()
        );

        // --

        $article = new Article($this->product, 1);

        $article->incrementAmount(4);

        $this->assertEquals(
            5,
            $article->getAmount()
        );
    }

    public function testDecrementAmount()
    {
        $article = new Article($this->product, 2);

        $article->decrementAmount();

        $this->assertEquals(
            1,
            $article->getAmount()
        );

        // --

        $article = new Article($this->product, 5);

        $article->decrementAmount(4);

        $this->assertEquals(
            1,
            $article->getAmount()
        );
    }

    public function testGetSum()
    {
        $article = new Article($this->product, 1);

        $this->assertEquals(
            new Price(1200, 'EUR'),
            $article->getSum()
        );

        // --

        $article->setAmount(2);

        $this->assertEquals(
            new Price(2400, 'EUR'),
            $article->getSum()
        );
    }
}
