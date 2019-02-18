<?php

namespace jregner\ShopBase\Interfaces;

use Doctrine\Common\Collections\ArrayCollection;

interface ICart
{
    public function get(): ArrayCollection;

    public function clear(): void;
}
