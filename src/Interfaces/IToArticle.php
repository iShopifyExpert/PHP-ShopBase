<?php

namespace jregner\ShopBase\Interfaces;

interface IToArticle
{
    /**
     * Reduce product to a shopping cart article.
     *
     * @return IArticle
     */
    public function toArticle(): IArticle;
}
