<?php

namespace jregner\ShopBase\Interfaces;

use Doctrine\Common\Collections\ArrayCollection;

interface ICart
{
    public function getArticles(): ArrayCollection;

    public function clearArticles(): void;
}
