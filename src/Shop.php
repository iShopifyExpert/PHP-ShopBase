<?php

namespace jregner\ShopBase;

use jregner\ShopBase\Exceptions\Product\ProductAlreadyExistsException;
use jregner\ShopBase\Exceptions\Product\ProductInvalidArticleNumberException;

class Shop
{
    protected $products = [];

    /**
     * Shop constructor.
     *
     * @param array $products
     *
     * @throws ProductAlreadyExistsException
     */
    public function __construct(array $products)
    {
        $this->setProducts($products);
    }

    /**
     * Add new shop product.
     *
     * @param Product $product
     *
     * @return Shop
     *
     * @throws ProductAlreadyExistsException
     */
    public function addProduct(Product $product): self
    {
        if ($this->hasProduct($product->getArticleNumber())) {
            throw new ProductAlreadyExistsException('The product with article number ' . $product->getArticleNumber() . ' is already added!');
        }

        $this->products[$product->getArticleNumber()] = $product;

        return $this;
    }

    /**
     * Update shop product.
     *
     * @param string  $articleNumber
     * @param Product $product
     *
     * @return Shop
     *
     * @throws ProductInvalidArticleNumberException
     */
    public function updateProduct(string $articleNumber, Product $product): self
    {
        if ($product->getArticleNumber() !== $articleNumber) {
            throw new ProductInvalidArticleNumberException('Article number does not match the product article number!');
        }

        $this->products[$articleNumber] = $product;

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
        unset($this->products[$articleNumber]);

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
        return array_key_exists($articleNumber, $this->products);
    }

    /**
     * Get shop product.
     *
     * @param string $articleNumber
     *
     * @return Product
     */
    public function getProduct(string $articleNumber): Product
    {
        return $this->products[$articleNumber];
    }

    /**
     * Set shop products.
     *
     * @param array $products
     *
     * @return $this
     *
     * @throws ProductAlreadyExistsException
     */
    public function setProducts(array $products)
    {
        $this->products = [];
        foreach ($products as $product) {
            $this->addProduct($product);
        }

        return $this;
    }

    /**
     * Get shop products.
     *
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }
}
