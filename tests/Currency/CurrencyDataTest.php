<?php
namespace App\Currency;

use PHPUnit\Framework\TestCase;
use App\Currency\CurrencyData;

class CurrencyDataTest extends TestCase
{
    /**
     * @covers \CurrencyDataTest
     */
    public function testSetExchangeRate() {
        CurrencyData::setExchangeRate('EUR', 'RUB', 50);
        CurrencyData::getExchangeRate('EUR');
        $this->assertEquals(50,CurrencyData::getExchangeRate('EUR')['RUB']);
    }

    /**
     * @covers \CurrencyDataTest
     */
    public function testGetExchangeRate() {
        CurrencyData::setExchangeRate('EUR', 'RUB', 80);
        CurrencyData::getExchangeRate('EUR');
        $this->assertEquals(80,CurrencyData::getExchangeRate('EUR')['RUB']);
    }
}
