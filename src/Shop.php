<?php

namespace jregner\ShopBase;

class Shop
{
    protected $products = [];

    public function __construct(array $products)
    {
        $this->setProducts($products);
    }

    public function addProduct(Product $product): self
    {
        if ($this->hasProduct($product->getArticleNumber())) {
            // TODO: Throw Product Already Exists Exception
        }

        $this->products[$product->getArticleNumber()] = $product;

        return $this;
    }

    public function updateProduct(string $articleNumber, Product $product): self
    {
        if ($product->getArticleNumber() !== $articleNumber) {
            // TODO: Throw Update Wrong Product Exception
        }

        $this->products[$articleNumber] = $product;

        return $this;
    }

    public function removeProduct(string $articleNumber): self
    {
        unset($this->products[$articleNumber]);

        return $this;
    }

    public function hasProduct(string $articleNumber): bool
    {
        return array_key_exists($articleNumber, $this->products);
    }

    public function setProducts(array $products)
    {
        $this->products = [];
        foreach ($products as $product) {
            $this->addProduct($product);
        }

        return $this;
    }

    public function getProducts(): array
    {
        return $this->products;
    }
}
