<?php

namespace jregner\ShopBase;

use Doctrine\Common\Collections\ArrayCollection;
use jregner\ShopBase\Interfaces\IArticle;
use jregner\ShopBase\Types\Price;

class Cart
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
     * Add product to shopping cart.
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
     * Remove product from shopping cart.
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
     * Raise product amount.
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
     * Reduce product amount.
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
