<?php

namespace jregner\ShopBase\Interfaces;

use jregner\ShopBase\Types\Price;

interface IArticle
{
    /**
     * Get article number.
     *
     * @return string
     */
    public function getArticleNumber(): string;

    /**
     * Set article amount.
     *
     * @param int $amount
     *
     * @return IArticle
     */
    public function setAmount(int $amount): self;

    /**
     * Get article amount.
     *
     * @return int
     */
    public function getAmount(): int;

    /**
     * Set article price.
     *
     * @param Price $price
     *
     * @return IArticle
     */
    public function setPrice(Price $price): self;

    /**
     * Get article price.
     *
     * @return Price
     */
    public function getPrice(): ?Price;

    /**
     * Get article sum.
     *
     * @return Price
     */
    public function getSum(): Price;
}
