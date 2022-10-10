<?php
namespace App\Accounts;

use PHPUnit\Framework\TestCase;
use App\Accounts\MultiCurrencyAccount;
use App\Currency\Currency;
use App\Currency\Currencies\{Rub, Eur, Usd};

class MultiCurrencyAccountTest extends TestCase
{
    const CURRENCY_RUB = 'RUB';
    const CURRENCY_EUR = 'EUR';
    const CURRENCY_USD = 'USD';

    private MultiCurrencyAccount $account;

    /**
     * @covers \MultiCurrencyAccount
     */
    protected function setUp(): void
    {
        $this->account = new MultiCurrencyAccount();
    }

    /**
     * @covers \MultiCurrencyAccount
     */
    public function testAddCurrency(): void
    {
        $this->account->addCurrency(self::CURRENCY_RUB);
        $this->assertInstanceOf(
            Rub::class,
            $this->account->getAccount(self::CURRENCY_RUB),
            "Account is not instance of Rub"
        );
        $this->account->addCurrency(self::CURRENCY_EUR);
        $this->assertInstanceOf(
            Eur::class,
            $this->account->getAccount(self::CURRENCY_EUR),
            "Account is not instance of Eur"
        );
        $this->account->addCurrency(self::CURRENCY_USD);
        $this->assertInstanceOf(
            Usd::class,
            $this->account->getAccount(self::CURRENCY_USD),
            "Account is not instance of Usd"
        );
    }

    /**
     * @covers \MultiCurrencyAccount
     */
    public function testGetAccount(): void {
        $this->account->addCurrency(self::CURRENCY_RUB);
        $this->assertInstanceOf(
            Rub::class,
            $this->account->getAccount(self::CURRENCY_RUB),
            "Account is not instance of RUB"
        );
    }

    /**
     * @covers \MultiCurrencyAccount
     */
    public function testRemoveAccount(): void {
        try {
            $this->account->addCurrency(self::CURRENCY_RUB);
            $this->account->removeAccount(self::CURRENCY_RUB);
            $this->assertFalse($this->account->getAccount(self::CURRENCY_RUB), "Account is not removed");
        } catch (\Exception $e) {
            $this->assertEquals(
                "Account currency name not found",
                $e->getMessage());
            return;
        }
        $this->fail( "No account expected") ;
    }

    /**
     * @covers \MultiCurrencyAccount
     */
    public function testDeposit(): void {
        $this->account->addCurrency(self::CURRENCY_RUB);
        $this->account->deposit(new Rub(1000));
        $this->assertEquals(1000, $this->account->getBalance(self::CURRENCY_RUB));
    }

    /**
     * @covers \MultiCurrencyAccount
     */
    public function testWithdraw(): void {
        $this->account->addCurrency(self::CURRENCY_RUB);
        $this->account->deposit(new Rub(1000));
        $this->account->withdraw(new Rub(10));
        $this->assertEquals(990, $this->account->getBalance(self::CURRENCY_RUB));
    }

    /**
     * @covers \MultiCurrencyAccount
     */
    public function testGetBalance(): void {
        $this->account->addCurrency(self::CURRENCY_RUB);
        $this->account->deposit(new Rub(1000));
        $this->assertEquals(1000, $this->account->getBalance(self::CURRENCY_RUB));
    }

    /**
     * @covers \MultiCurrencyAccount
     */
    public function testGetSuppliedCurrency(): void {
        $currencies = ['RUB', 'EUR', 'USD'];
        $this->account->addCurrency(self::CURRENCY_RUB);
        $this->account->addCurrency(self::CURRENCY_EUR);
        $this->account->addCurrency(self::CURRENCY_USD);
        $this->assertEquals($currencies, $this->account->getSuppliedCurrency());
    }

    /**
     * @covers \MultiCurrencyAccount
     */
    public function testSetDefaultCurrency(): void {
        $this->account->addCurrency(self::CURRENCY_RUB);
        $this->account->setDefaultCurrency(self::CURRENCY_RUB);
        $this->assertEquals("RUB", $this->account->getDefaultCurrency());
    }
}
