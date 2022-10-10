<?php
namespace App\Currency;

use PHPUnit\Framework\TestCase;
use App\Currency\CurrencyData;
use App\Currency\Currencies\{Rub, Eur, Usd};

class RubTest extends TestCase {
    private Rub $rub;

    /**
     * @covers \Rub
     */
    protected function setUp(): void
    {
        $this->rub = new Rub(50);
        $this->eur = new Eur(50);
        $this->usd = new Usd(50);
    }

    /**
     * @covers \Rub
     */
    public function testGetBalance() {
        $this->assertEquals(50, $this->rub->getBalance());
    }

    /**
     * @covers \Rub
     */
    public function testSetBalance() {
        $this->rub->setBalance(100);
        $this->assertEquals(100, $this->rub->getBalance());
    }

    /**
     * @covers \Rub
     */
    public function testConvertCurrency() {
        // Rub conversion
        $cash = $this->rub->convertCurrency(new Eur(120));
        $this->assertEquals(9600, $cash);
        $cash = $this->rub->convertCurrency(new Usd(120));
        $this->assertEquals(8400, $cash);
        $cash = $this->rub->convertCurrency(new Rub(120));
        $this->assertEquals(120, $cash);

        // Eur conversion
        $cash = $this->eur->convertCurrency(new Eur(120));
        $this->assertEquals(120, $cash);
        $cash = $this->eur->convertCurrency(new Usd(120));
        $this->assertEquals(120, $cash);
        $cash = $this->eur->convertCurrency(new Rub(120));
        $this->assertEquals(1.5, $cash);

        // Usd conversion
        $cash = $this->usd->convertCurrency(new Eur(120));
        $this->assertEquals(120, $cash);
        $cash = $this->usd->convertCurrency(new Usd(120));
        $this->assertEquals(120, $cash);
        $cash = $this->usd->convertCurrency(new Rub(120));
        $this->assertEquals(1.71, $cash);
    }

    /**
     * @covers \Rub
     */
    public function testSetExchangeRate() {
        $this->rub::setExchangeRate('EUR', 200);
        $rub = CurrencyData::getExchangeRate('RUB')['EUR'];
        $this->assertEquals(200 , $rub);
    }
}
