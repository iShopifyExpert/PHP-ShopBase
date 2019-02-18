<?php

namespace jregner\ShopBase;

use jregner\ShopBase\Interfaces\IArticle;
use jregner\ShopBase\Interfaces\IToArticle;
use jregner\ShopBase\Types\Price;

class Article implements IArticle
{
    private $articleNumber;

    protected $amount = 1;

    /** @var Price */
    protected $price;

    public function __construct(string $articleNumber, Price $price)
    {
        $this->articleNumber = $articleNumber;
        $this->price = $price;
    }

    public static function fromProduct(IToArticle $product): IArticle
    {
        return $product->toArticle();
    }

    public function getArticleNumber(): string
    {
        return $this->articleNumber;
    }

    public function setAmount(int $amount): IArticle
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setPrice(Price $price): IArticle
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getSum(): Price
    {
        return new Price($this->amount * $this->price->getValue(), $this->price->getCurrency());
    }
}
