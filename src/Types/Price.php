<?php

namespace jregner\ShopBase\Types;

use jregner\ShopBase\Exceptions\Types\InvalidCurrencyException;
use Symfony\Component\Intl\Intl;

class Price
{
    protected $value;
    protected $currency;

    /**
     * Price constructor.
     *
     * @param int    $value
     * @param string $currency
     *
     * @throws InvalidCurrencyException
     */
    public function __construct(int $value, string $currency)
    {
        if (null === Intl::getCurrencyBundle()->getCurrencyName($currency)) {
            throw new InvalidCurrencyException($currency . ' is not a valid currency.');
        }

        $this->value = $value;
        $this->currency = $currency;
    }

    /**
     * Get value.
     *
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Get currency.
     *
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * Format price.
     *
     * @param $locale
     * @param int $style
     *
     * @return string
     */
    public function format($locale, $style = \NumberFormatter::CURRENCY): string
    {
        $formatter = new \NumberFormatter($locale, $style);

        return $formatter->formatCurrency($this->value / 100, $this->currency);
    }
}
