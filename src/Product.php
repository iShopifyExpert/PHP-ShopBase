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

    public function __construct(string $articleNumber, string $name, Price $price)
    {
        $this->articleNumber = $articleNumber;
        $this->name = $name;
        $this->price = $price;
    }

    public function getArticleNumber(): string
    {
        return $this->articleNumber;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setPrice(Price $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function addCategory(string $category): self
    {
        $this->categories[] = $category;

        return $this;
    }

    public function removeCategory(string $category): self
    {
        if (false !== $key = array_search($category, $this->categories, true)) {
            unset($this->categories[$key]);

            $this->categories = array_values($this->categories);
        }

        return $this;
    }

    public function hasCategory(string $category): bool
    {
        return in_array($category, $this->categories, true);
    }

    public function setCategories(array $categories): self
    {
        foreach ($categories as $category) {
            $this->addCategory($category);
        }

        return $this;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }
}
