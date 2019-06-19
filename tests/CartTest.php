<?php

use PHPUnit\Framework\TestCase;
use jregner\ShopBase\Cart;
use jregner\ShopBase\Article;
use jregner\ShopBase\Product;
use jregner\ShopBase\Types\Price;

class CartTest extends TestCase
{
    /** @var Cart */
    private $cart;

    private $articles;

    protected function setUp(): void
    {
        $articles = [];
        for ($i = 0; $i < 5; ++$i) {
            $articles[] = new Article(
                new Product((string) $i, 'Product Number ' . $i, new Price(1000 * $i, 'EUR')),
                $i + 1
            );
        }

        $cart = new Cart();
        foreach ($articles as $article) {
            $cart->addArticle($article);
        }

        $this->articles = $articles;
        $this->cart = $cart;
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(
            Cart::class,
            new Cart()
        );
    }

    public function testGetEmptyArticles()
    {
        $cart = new Cart();

        $this->assertEquals(
            [],
            $cart->getArticles()->toArray()
        );
    }

    public function testGetArticles()
    {
        $this->assertEquals(
            $this->articles,
            $this->cart->getArticles()->toArray()
        );
    }

    public function testAddArticle()
    {
        $cart = new Cart();
        $article = new Article(new Product('1234', 'Product Number 1234', new Price(1200, 'EUR')), 1);

        $cart->addArticle($article);

        $this->assertEquals(
            ['1234' => new Article(new Product('1234', 'Product Number 1234', new Price(1200, 'EUR')), 1)],
            $cart->getArticles()->toArray()
        );
    }

    public function testRemoveArticle()
    {
        $cart = new Cart();
        $article = new Article(new Product('1234', 'Product Number 1234', new Price(1200, 'EUR')), 1);

        $cart->addArticle($article);

        $cart->removeArticle($article->getProduct()->getArticleNumber());

        $this->assertEquals(
            [],
            $cart->getArticles()->toArray()
        );
    }

    public function testClearArticles()
    {
        $this->cart->clearArticles();

        $this->assertEquals(
            [],
            $this->cart->getArticles()->toArray()
        );
    }

    public function testGetSum()
    {
        $this->assertEquals(
            new Price(40000, 'EUR'),
            $this->cart->getSum()
        );
    }
}
