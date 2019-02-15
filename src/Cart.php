<?php

namespace jregner\ShopBase;

use Doctrine\Common\Collections\ArrayCollection;
use jregner\ShopBase\Types\Price;

class Cart
{
    protected $cart;

    /**
     * Cart constructor.
     */
    public function __construct()
    {
        $this->cart = new ArrayCollection();
    }

    /**
     * Add product to shopping cart.
     *
     * @param Product $product
     * @param int     $amount
     *
     * @return Cart
     */
    public function add(Product $product, int $amount = 1): self
    {
        $this->cart->set($product->getArticleNumber(), [
            'amount' => $amount,
            'product' => $product,
        ]);

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
        $this->cart->remove($articleNumber);

        return $this;
    }

    /**
     * Get products from shopping cart.
     *
     * @return ArrayCollection
     */
    public function get(): ArrayCollection
    {
        return $this->cart;
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
        $article = $this->cart->get($articleNumber);

        ++$article['amount'];

        $this->cart->set($articleNumber, $article);

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
        $article = $this->cart->get($articleNumber);

        --$article['amount'];

        $this->cart->set($articleNumber, $article);

        return $this;
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
        $price = array_reduce($this->cart->getValues(), function ($sum, $item) use (&$currency) {
            /** @var Product $product */
            $product = $item['product'];
            $amount = $item['amount'];
            $currency = $product->getPrice()->getCurrency();

            return $sum + $product->getPrice()->getValue() * $amount;
        });

        return new Price($price, $currency);
    }

    /**
     * Checkout shopping cart.
     *
     * @return ArrayCollection
     */
    public function checkout(): ArrayCollection
    {
        $data = new ArrayCollection();

        foreach ($this->cart as $articleNumber => $item) {
            $data->set($articleNumber, $item['amount']);
        }

        $this->cart->clear();

        return $data;
    }
}
