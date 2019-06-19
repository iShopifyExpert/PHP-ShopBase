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
     * Add a new article to shopping cart.
     *
     * @param IArticle $article
     *
     * @return Cart
     */
    public function addArticle(IArticle $article): self
    {
        $this->articles->set($article->getProduct()->getArticleNumber(), $article);

        return $this;
    }

    /**
     * Remove a article from shopping cart.
     *
     * @param string $articleNumber
     *
     * @return Cart
     */
    public function removeArticle(string $articleNumber): self
    {
        $this->articles->remove($articleNumber);

        return $this;
    }

    /**
     * Get article.
     *
     * @param string $articleNumber
     *
     * @return IArticle|null
     */
    public function getArticle(string $articleNumber): ?IArticle
    {
        if (!$this->articles->containsKey($articleNumber)) {
            return null;
        }

        return $this->articles->get($articleNumber);
    }

    /**
     * Get articles from shopping cart.
     *
     * @return ArrayCollection
     */
    public function getArticles(): ArrayCollection
    {
        return $this->articles;
    }

    /**
     * Clear shopping cart.
     */
    public function clearArticles(): void
    {
        $this->articles->clear();
    }

    /**
     * Get article count.
     *
     * @return int
     */
    public function getCount(): int
    {
        return $this->articles->count();
    }

    /**
     * Get shopping cart sum.
     *
     * @return Price
     *
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
