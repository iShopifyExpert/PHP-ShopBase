<?php

namespace jregner\ShopBase;

use jregner\ShopBase\Interfaces\IArticle;
use jregner\ShopBase\Interfaces\IProduct;
use jregner\ShopBase\Types\Price;

class Article implements IArticle
{
    private $product;

    protected $amount;

    public function __construct(IProduct $product, int $amount)
    {
        $this->product = $product;
        $this->amount = $amount;
    }

    public function getProduct(): IProduct
    {
        return $this->product;
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

    public function incrementAmount(int $number = 1): self
    {
        $this->amount += $number;

        return $this;
    }

    public function decrementAmount(int $number = 1): self
    {
        $this->amount -= $number;

        return $this;
    }

    public function getSum(): Price
    {
        return new Price(
            $this->product->getPrice()->getValue() * $this->amount,
            $this->product->getPrice()->getCurrency()
        );
    }
}
