<?php

namespace jregner\ShopBase;

use Doctrine\Common\Collections\ArrayCollection;
use jregner\ShopBase\Interfaces\IArticle;
use jregner\ShopBase\Interfaces\ICart;
use jregner\ShopBase\Types\Price;

class Cart implements ICart
{
    protected $articles;

    /**
     * Cart constructor.
     */
    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    /**
     * Add article to shopping cart.
     *
     * @param IArticle $article
     * @param int      $amount
     *
     * @return Cart
     */
    public function add(IArticle $article, int $amount = 1): self
    {
        $article->setAmount($amount);

        $this->articles->set($article->getArticleNumber(), $article);

        return $this;
    }

    /**
     * Remove article from shopping cart.
     *
     * @param string $articleNumber
     *
     * @return Cart
     */
    public function remove(string $articleNumber): self
    {
        $this->articles->remove($articleNumber);

        return $this;
    }

    /**
     * Get products from shopping cart.
     *
     * @return ArrayCollection
     */
    public function get(): ArrayCollection
    {
        return $this->articles;
    }

    /**
     * Raise article amount.
     *
     * @param string $articleNumber
     *
     * @return Cart
     */
    public function raiseAmount(string $articleNumber): self
    {
        $article = $this->articles->get($articleNumber);

        $article->setAmount($article->getAmount() + 1);

        $this->articles->set($articleNumber, $article);

        return $this;
    }

    /**
     * Reduce article amount.
     *
     * @param string $articleNumber
     *
     * @return Cart
     */
    public function reduceAmount(string $articleNumber): self
    {
        $article = $this->articles->get($articleNumber);

        $article->setAmount($article->getAmount() - 1);

        $this->articles->set($articleNumber, $article);

        return $this;
    }

    /**
     * Clear shopping cart
     */
    public function clear(): void
    {
        $this->articles->clear();
    }

    /**
     * Get shopping cart sum
     *
     * @return Price
     * @throws Exceptions\Types\InvalidCurrencyException
     */
    public function getSum(): Price
    {
        $sum = 0;
        $currency = '';

        /** @var IArticle $article */
        foreach ($this->articles as $article) {
            $sum += $article->getSum()->getValue();
            $currency = $article->getSum()->getCurrency();
        }

        return new Price($sum, $currency);
    }
}
