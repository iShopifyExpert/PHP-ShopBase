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
}
