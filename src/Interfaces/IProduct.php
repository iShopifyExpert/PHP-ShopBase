<?php

namespace jregner\ShopBase\Interfaces;

use jregner\ShopBase\Types\Price;

interface IProduct
{
    /**
     * Get article number.
     *
     * @return string
     */
    public function getArticleNumber(): string;

    /**
     * Get product price.
     *
     * @return Price
     */
    public function getPrice(): Price;

    /**
     * Get product stock.
     *
     * @param int $stock
     *
     * @return IProduct
     */
    public function setStock(int $stock): self;

    /**
     * Set product stock.
     *
     * @return int|null
     */
    public function getStock(): ?int;
}
