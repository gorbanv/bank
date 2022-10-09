<?php
namespace App\Converter;

use App\Converter\Converters\EurConverter;
use App\Converter\Converters\RubConverter;
use App\Converter\Converters\UsdConverter;
use PHPUnit\Framework\TestCase;
use App\Converter\CurrencyConverter;

class CurrencyConverterTest extends TestCase
{
    const CURRENCY_RUB = 'RUB';
    const CURRENCY_EUR = 'EUR';
    const CURRENCY_USD = 'USD';

    public function testSetConverter() {
        $converter = new CurrencyConverter();
        $converter->prepareConverter(self::CURRENCY_RUB);
        $this->assertInstanceOf(
            RubConverter::class,
            $converter->getConverter(),
            "Converter is not instance of RubConverter"
        );
        $converter->prepareConverter(self::CURRENCY_EUR);
        $this->assertInstanceOf(
            EurConverter::class,
            $converter->getConverter(),
            "Converter is not instance of EurConverter"
        );
        $converter->prepareConverter(self::CURRENCY_USD);
        $this->assertInstanceOf(
            UsdConverter::class,
            $converter->getConverter(),
            "Converter is not instance of UsdConverter"
        );
    }

    public function testGetConverter() {
        $converter = new CurrencyConverter();
        $converter->prepareConverter(self::CURRENCY_RUB);
        $this->assertInstanceOf(
            RubConverter::class,
            $converter->getConverter(),
            "Converter is not instance of RubConverter"
        );
    }

    public function testPrepareConverter() {
        $converter = new CurrencyConverter();
        $converter->prepareConverter(self::CURRENCY_RUB);
        $this->assertInstanceOf(
            RubConverter::class,
            $converter->getConverter(),
            "Converter is not instance of RubConverter"
        );

        $converter->prepareConverter(self::CURRENCY_EUR);
        $this->assertInstanceOf(
            EurConverter::class,
            $converter->getConverter(),
            "Converter is not instance of EurConverter"
        );

        $converter->prepareConverter(self::CURRENCY_USD);
        $this->assertInstanceOf(
            UsdConverter::class,
            $converter->getConverter(),
            "Converter is not instance of UsdConverter"
        );
    }
}