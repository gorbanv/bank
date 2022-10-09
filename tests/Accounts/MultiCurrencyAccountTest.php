<?php
namespace App\Accounts;

use PHPUnit\Framework\TestCase;
use App\Accounts\MultiCurrencyAccount;
use App\Currency\Currency;
use App\Currency\Currencies\{Rub, Eur, Usd};

class MultiCurrencyAccountTest extends TestCase
{
    private MultiCurrencyAccount $account;

    protected function setUp(): void
    {
        $this->account = new MultiCurrencyAccount();
    }

    public function testAddCurrency(): void
    {
        $this->account->addCurrency("RUB");
        $this->assertInstanceOf(
            Rub::class,
            $this->account->getAccount("RUB"),
            "Account is not instance of Rub"
        );
        $this->account->addCurrency("EUR");
        $this->assertInstanceOf(
            Eur::class,
            $this->account->getAccount("EUR"),
            "Account is not instance of Eur"
        );
        $this->account->addCurrency("USD");
        $this->assertInstanceOf(
            Usd::class,
            $this->account->getAccount("USD"),
            "Account is not instance of Usd"
        );
    }

    public function testGetAccount(): void {
        $this->account->addCurrency("RUB");
        $this->assertInstanceOf(
            Rub::class,
            $this->account->getAccount("RUB"),
            "Account is not instance of RUB"
        );
    }

    public function testRemoveAccount(): void {
        try {
            $this->account->addCurrency("RUB");
            $this->account->removeAccount("RUB");
            $this->assertFalse($this->account->getAccount("RUB"), "Account is not removed");
        } catch (\Exception $e) {
            $this->assertEquals(
                "Account currency name not found",
                $e->getMessage());
            return;
        }
        $this->fail( "No account expected") ;
    }

    public function testDeposit(): void {
        $this->account->addCurrency("RUB");
        $this->account->deposit(new Rub(1000));
        $this->assertEquals(1000, $this->account->getBalance('RUB'));
    }

    public function testWithdraw(): void {
        $this->account->addCurrency("RUB");
        $this->account->deposit(new Rub(1000));
        $this->account->withdraw(new Rub(10));
        $this->assertEquals(990, $this->account->getBalance('RUB'));
    }

    public function testGetBalance(): void {
        $this->account->addCurrency("RUB");
        $this->account->deposit(new Rub(1000));
        $this->assertEquals(1000, $this->account->getBalance('RUB'));
    }

    public function testGetSuppliedCurrency(): void {
        $currencies = ['RUB', 'EUR', 'USD'];
        $this->account->addCurrency('RUB');
        $this->account->addCurrency('EUR');
        $this->account->addCurrency('USD');
        $this->assertEquals($currencies, $this->account->getSuppliedCurrency());
    }

    public function testSetDefaultCurrency(): void {
        $this->account->addCurrency('RUB');
        $this->account->setDefaultCurrency('RUB');
        $this->assertEquals("RUB", $this->account->getDefaultCurrency());
    }
}