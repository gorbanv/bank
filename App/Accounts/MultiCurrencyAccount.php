<?php

namespace App\Accounts;

use App\Currency\Currency;
use App\Currency\Currencies\{Rub, Eur, Usd};
use App\Accounts\AccountException;

class MultiCurrencyAccount
{
    // supported account currencies
    const CURRENCY_RUB = 'RUB';
    const CURRENCY_EUR = 'EUR';
    const CURRENCY_USD = 'USD';

    // default currency
    private string $defaultCurrencyName;
    // array of currency account
    private array $accountCurrencies = [];

    /**
     * Add new currency to bank account $accountCurrencies
     * @param string $currencyName - currency name e.g 'RUB'
     * @return void
     * @throws \App\Accounts\AccountException
     */
    public function addCurrency(string $currencyName): void
    {
        if (array_key_exists($currencyName, $this->accountCurrencies)) {
            throw new AccountException('Currency already added');
        }

        switch ($currencyName) {
            case self::CURRENCY_RUB:
                $this->accountCurrencies[self::CURRENCY_RUB] = new Rub();
                break;
            case self::CURRENCY_EUR:
                $this->accountCurrencies[self::CURRENCY_EUR] = new Eur();
                break;
            case self::CURRENCY_USD:
                $this->accountCurrencies[self::CURRENCY_USD] = new Usd();
                break;
            default:
                throw new AccountException('Currency type not found');
        }
    }

    /**
     * Returns specify currency account
     * @param string $currencyName - currency name e.g. 'RUB'
     * @return Currency
     * @throws \App\Accounts\AccountException
     */
    public function getAccount(string $currencyName): Currency
    {
        if (!array_key_exists($currencyName, $this->accountCurrencies)) {
            throw new AccountException('Account currency name not found');
        }
        return $this->accountCurrencies[$currencyName];
    }

    /**
     * Remove specify account form $accountCurrencies
     * @param string $currencyName
     * @return void
     * @throws \App\Accounts\AccountException
     */
    public function removeAccount(string $currencyName): void
    {
        if (!array_key_exists($currencyName, $this->accountCurrencies)) {
            throw new AccountException('Account currency name not found');
        }
        unset($this->accountCurrencies[$currencyName]);
    }

    /**
     * Add currency balance to specify currency balance
     * @param Currency $currency - object of Currency e.g. RUB(100)
     * @return void
     * @throws \App\Accounts\AccountException
     */
    public function deposit(Currency $currency): void
    {
        if (!array_key_exists($currency::CURRENCY_NAME, $this->accountCurrencies)) {
            throw new AccountException('Currency account not found');
        }

        $this->accountCurrencies[$currency::CURRENCY_NAME]->setBalance(
            $this->accountCurrencies[$currency::CURRENCY_NAME]->getBalance()
            + $currency->getBalance()
        );
    }

    /**
     * Withdraw currency balance from specify currency e.g. RUB(100)
     * @param Currency $currency
     * @return Currency
     * @throws \App\Accounts\AccountException
     */
    public function withdraw(Currency $currency): Currency
    {
        if (!array_key_exists($currency::CURRENCY_NAME, $this->accountCurrencies)) {
            throw new AccountException('Currency account not found');
        }

        $currentBalance = $this->accountCurrencies[$currency::CURRENCY_NAME]->getBalance();
        $withdrawBalance = $currency->getBalance();

        if ($currentBalance < $withdrawBalance) {
            throw new AccountException('Not enough funds in the account');
        }

        $this->accountCurrencies[$currency::CURRENCY_NAME]->setBalance($currentBalance - $withdrawBalance);

        return $this->accountCurrencies[$currency::CURRENCY_NAME];
    }

    /**
     * Returns specify currency balance of default currency
     * @param string|null $currencyName - currency name e.g. 'RUB'
     * @return float
     * @throws \App\Accounts\AccountException
     */
    public function getBalance(string $currencyName = null): float
    {
        if (!$currencyName && $this->defaultCurrencyName && array_key_exists($this->defaultCurrencyName, $this->accountCurrencies)) {
            return $this->accountCurrencies[$this->defaultCurrencyName]->getBalance();
        } elseif ($currencyName && array_key_exists($currencyName, $this->accountCurrencies)) {
            return $this->accountCurrencies[$currencyName]->getBalance();
        } else {
            throw new AccountException('Account currency name not found');
        }
    }

    /**
     * Returns array of supplied currencies $accountCurrencies
     * @return array
     */
    public function getSuppliedCurrency(): array
    {
        return array_keys($this->accountCurrencies);
    }

    /**
     * Sets default currency for account e.g. 'RUB'
     * @param string $defaultCurrencyName - currency name e.g. 'RUB'
     * @return void
     * @throws \App\Accounts\AccountException
     */
    public function setDefaultCurrency(string $defaultCurrencyName): void
    {
        if (!array_key_exists($defaultCurrencyName, $this->accountCurrencies)) {
            throw new AccountException('Account currency name not found');
        }

        $this->defaultCurrencyName = $defaultCurrencyName;
    }

    /**
     * Returns default currency for account e.g. 'RUB'
     * @return string
     */
    public function getDefaultCurrency(): string {
        return $this->defaultCurrencyName;
    }
}
