<?php

namespace jregner\ShopBase\Types;

use Symfony\Component\Intl\Intl;

class Price
{
    protected $value;
    protected $currency;

    public function __construct(int $value, string $currency)
    {
        if (null === Intl::getCurrencyBundle()->getCurrencyName($currency)) {
            // TODO: throw new Invalid Currency Exception
        }

        $this->value = $value;
        $this->currency = $currency;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function format($locale, $style = \NumberFormatter::CURRENCY): string
    {
        $formatter = new \NumberFormatter($locale, $style);

        return $formatter->formatCurrency($this->value / 100, $this->currency);
    }
}
