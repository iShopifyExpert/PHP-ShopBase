<?php

use PHPUnit\Framework\TestCase;
use jregner\ShopBase\Types\Price;
use jregner\ShopBase\Exceptions\Types\InvalidCurrencyException;

class PriceTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf(
            Price::class,
            new Price(1200, 'EUR')
        );
    }

    public function testConstructWithInvalidCurrency()
    {
        $this->expectException(InvalidCurrencyException::class);

        $price = new Price(1200, 'EURO');
    }

    public function testGetValue()
    {
        $price = new Price(1200, 'EUR');

        $this->assertEquals(
            1200,
            $price->getValue()
        );
    }

    public function testGetCurrency()
    {
        $price = new Price(1200, 'EUR');

        $this->assertEquals(
            'EUR',
            $price->getCurrency()
        );
    }

    public function testFormatEUR()
    {
        $price = new Price(119999, 'EUR');

        $this->assertEquals(
            '1.199,99 €',
            $price->format('de')
        );

        $this->assertEquals(
            '€1,199.99',
            $price->format('en')
        );

        $this->assertEquals(
            '1 199,99 €',
            $price->format('fr')
        );
    }

    public function testFormatUSD()
    {
        $price = new Price(119999, 'USD');

        $this->assertEquals(
            '1.199,99 $',
            $price->format('de')
        );

        $this->assertEquals(
            '$1,199.99',
            $price->format('en')
        );

        $this->assertEquals(
            '1 199,99 $US',
            $price->format('fr')
        );
    }
}
