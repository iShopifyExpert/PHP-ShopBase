<?php

namespace jregner\ShopBase;

use Doctrine\Common\Collections\ArrayCollection;
use jregner\ShopBase\Interfaces\IOrder;

class Order implements IOrder
{
    protected $articles;

    public function __construct(ArrayCollection $articles)
    {
        $this->articles = $articles;
    }

    public function getArticles(): ArrayCollection
    {
        return $this->articles;
    }
}
