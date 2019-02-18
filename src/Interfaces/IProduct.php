<?php

namespace jregner\ShopBase\Interfaces;

interface IProduct
{
    /**
     * Get article number.
     *
     * @return string
     */
    public function getArticleNumber(): string;

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
