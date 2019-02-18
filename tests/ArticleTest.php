<?php

use PHPUnit\Framework\TestCase;
use jregner\ShopBase\Article;
use jregner\ShopBase\Product;
use jregner\ShopBase\Types\Price;
use jregner\ShopBase\Interfaces\IArticle;

class ArticleTest extends TestCase
{
    public function testConstruct()
    {
        $article = new Article('1234', new Price(1200, 'EUR'));

        $this->assertInstanceOf(
            Article::class,
            $article
        );

        $this->assertInstanceOf(
            IArticle::class,
            $article
        );
    }

    public function testFromProduct()
    {
        $product = new Product('1234', 'Product 1234', new Price(1200, 'EUR'));

        $article = Article::fromProduct($product);

        $article2 = new Article('1234', new Price(1200, 'EUR'));

        $this->assertEquals(
            $article2,
            $article
        );
    }

    public function testGetArticleNumber()
    {
        $article = new Article('1234', new Price(1200, 'EUR'));

        $this->assertEquals(
            '1234',
            $article->getArticleNumber()
        );
    }

    public function testGetAmount()
    {
        $article = new Article('1234', new Price(1200, 'EUR'));

        $this->assertEquals(
            1,
            $article->getAmount()
        );
    }

    public function testSetAmount()
    {
        $article = new Article('1234', new Price(1200, 'EUR'));

        $article->setAmount(2);

        $this->assertEquals(
            2,
            $article->getAmount()
        );
    }

    public function testGetPrice()
    {
        $article = new Article('1234', new Price(1200, 'EUR'));

        $this->assertEquals(
            new Price(1200, 'EUR'),
            $article->getPrice()
        );
    }

    public function testSetPrice()
    {
        $article = new Article('1234', new Price(1200, 'EUR'));

        $article->setPrice(new Price(2400, 'EUR'));

        $this->assertEquals(
            new Price(2400, 'EUR'),
            $article->getPrice()
        );
    }

    public function testGetSum()
    {
        $article = new Article('1234', new Price(1200, 'EUR'));

        $this->assertEquals(
            new Price(1200, 'EUR'),
            $article->getSum()
        );

        $article->setAmount(2);

        $this->assertEquals(
            new Price(2400, 'EUR'),
            $article->getSum()
        );
    }
}
