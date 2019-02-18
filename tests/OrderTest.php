<?php

use PHPUnit\Framework\TestCase;
use jregner\ShopBase\Order;
use jregner\ShopBase\Interfaces\IOrder;
use jregner\ShopBase\Article;
use jregner\ShopBase\Types\Price;
use Doctrine\Common\Collections\ArrayCollection;

class OrderTest extends TestCase
{
    public function testConstruct()
    {
        $articles = new ArrayCollection([
            new Article('1234', new Price(1200, 'EUR')),
            new Article('5678', new Price(2400, 'EUR')),
            new Article('9101', new Price(3600, 'EUR')),
        ]);

        $order = new Order($articles);

        $this->assertInstanceOf(
            Order::class,
            $order
        );

        $this->assertInstanceOf(
            IOrder::class,
            $order
        );
    }

    public function testGetArticles()
    {
        $articles = new ArrayCollection([
            new Article('1234', new Price(1200, 'EUR')),
            new Article('5678', new Price(2400, 'EUR')),
            new Article('9101', new Price(3600, 'EUR')),
        ]);

        $order = new Order($articles);

        $this->assertEquals(
            $articles,
            $order->getArticles()
        );
    }
}
