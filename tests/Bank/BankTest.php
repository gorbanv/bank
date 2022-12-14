<?php
namespace App\Bank;

use PHPUnit\Framework\TestCase;
use App\Accounts\MultiCurrencyAccount;

class BankTest extends TestCase
{
    private Bank $bank;

    /**
     * @covers \Bank
     */
    protected function setUp(): void
    {
        $this->bank = new Bank();
    }

    /**
     * @covers \Bank
     */
    public function testCreateNewCurrencyAccount(): void {
        $account = $this->bank->createNewCurrencyAccount();
        $this->assertInstanceOf(MultiCurrencyAccount::class, $account, "Account is not instance of MultiCurrencyAccount");
    }
}
