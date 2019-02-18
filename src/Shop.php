<?php

namespace jregner\ShopBase;

use Doctrine\Common\Collections\ArrayCollection;
use jregner\ShopBase\Exceptions\Product\ProductAlreadyExistsException;
use jregner\ShopBase\Interfaces\IArticle;
use jregner\ShopBase\Interfaces\ICart;
use jregner\ShopBase\Interfaces\IOrder;
use jregner\ShopBase\Interfaces\IProduct;

class Shop
{
    /** @var ArrayCollection */
    protected $products;

    /**
     * Shop constructor.
     *
     * @param ArrayCollection $products
     *
     * @throws ProductAlreadyExistsException
     */
    public function __construct(ArrayCollection $products)
    {
        $this->setProducts($products);
    }

    /**
     * Add new shop product.
     *
     * @param IProduct $product
     *
     * @return Shop
     *
     * @throws ProductAlreadyExistsException
     */
    public function addProduct(IProduct $product): self
    {
        if ($this->hasProduct($product->getArticleNumber())) {
            throw new ProductAlreadyExistsException('The product with article number ' . $product->getArticleNumber() . ' is already added!');
        }

        $this->products->set($product->getArticleNumber(), $product);

        return $this;
    }

    /**
     * Remove shop product.
     *
     * @param string $articleNumber
     *
     * @return Shop
     */
    public function removeProduct(string $articleNumber): self
    {
        $this->products->remove($articleNumber);

        return $this;
    }

    /**
     * Check whether a shop product exists.
     *
     * @param string $articleNumber
     *
     * @return bool
     */
    public function hasProduct(string $articleNumber): bool
    {
        return $this->products->containsKey($articleNumber);
    }

    /**
     * Get shop product.
     *
     * @param string $articleNumber
     *
     * @return IProduct
     */
    public function getProduct(string $articleNumber): IProduct
    {
        return $this->products->get($articleNumber);
    }

    /**
     * Set shop products.
     *
     * @param ArrayCollection $products
     *
     * @return $this
     *
     * @throws ProductAlreadyExistsException
     */
    public function setProducts(ArrayCollection $products): self
    {
        $this->products = new ArrayCollection();

        foreach ($products as $product) {
            $this->addProduct($product);
        }

        return $this;
    }

    /**
     * Get shop products.
     *
     * @return ArrayCollection
     */
    public function getProducts(): ArrayCollection
    {
        return $this->products;
    }

    /**
     * Checkout shopping cart.
     *
     * @param ICart $cart
     * @param null  $billingAddress
     * @param null  $shippingAddress
     *
     * @return IOrder
     */
    public function checkout(ICart $cart, $billingAddress = null, $shippingAddress = null): IOrder
    {
        $articles = $cart->get();

        /** @var IArticle $article */
        foreach ($articles as $articleNumber => $article) {
            /** @var IProduct $product */
            $product = $this->products->get($articleNumber);

            if (null !== $product->getStock()) {
                $product->setStock($product->getStock() - $article->getAmount());
            }

            $this->products->set($product->getArticleNumber(), $product);
        }

        $order = new Order($articles);

        $cart->clear();

        return $order;
    }
}
