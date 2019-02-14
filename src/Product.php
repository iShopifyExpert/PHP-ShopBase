<?php

namespace jregner\ShopBase;

use jregner\ShopBase\Types\Price;

class Product
{
    private $articleNumber;

    protected $name;
    protected $price;
    protected $description;
    protected $stock;
    protected $categories = [];

    /**
     * Product constructor.
     *
     * @param string $articleNumber
     * @param string $name
     * @param Price  $price
     */
    public function __construct(string $articleNumber, string $name, Price $price)
    {
        $this->articleNumber = $articleNumber;
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * Get article number.
     *
     * @return string
     */
    public function getArticleNumber(): string
    {
        return $this->articleNumber;
    }

    /**
     * Set product name.
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get product name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set product price.
     *
     * @param Price $price
     *
     * @return Product
     */
    public function setPrice(Price $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get product price.
     *
     * @return Price
     */
    public function getPrice(): Price
    {
        return $this->price;
    }

    /**
     * Set product description.
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get product description.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set product stock.
     *
     * @param int $stock
     *
     * @return Product
     */
    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get product stock.
     *
     * @return int|null
     */
    public function getStock(): ?int
    {
        return $this->stock;
    }

    /**
     * Add new product category.
     *
     * @param string $category
     *
     * @return Product
     */
    public function addCategory(string $category): self
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove product category.
     *
     * @param string $category
     *
     * @return Product
     */
    public function removeCategory(string $category): self
    {
        if (false !== $key = array_search($category, $this->categories, true)) {
            unset($this->categories[$key]);

            $this->categories = array_values($this->categories);
        }

        return $this;
    }

    /**
     * Check whether a product category exists.
     *
     * @param string $category
     *
     * @return bool
     */
    public function hasCategory(string $category): bool
    {
        return in_array($category, $this->categories, true);
    }

    /**
     * Set product categories.
     *
     * @param array $categories
     *
     * @return Product
     */
    public function setCategories(array $categories): self
    {
        foreach ($categories as $category) {
            $this->addCategory($category);
        }

        return $this;
    }

    /**
     * Get product categories.
     *
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }
}
