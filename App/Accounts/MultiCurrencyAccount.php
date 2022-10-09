<?php

namespace App\Accounts;

use App\Currency\{Currency, Rub, Eur, Usd};
use App\Accounts\AccountException;

class MultiCurrencyAccount
{
    const CURRENCY_RUB = 'RUB';
    const CURRENCY_EUR = 'EUR';
    const CURRENCY_USD = 'USD';

    private string $defaultCurrencyName;
    private array $accountCurrencies = [];

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

    public function getAccount(string $currencyName): Currency
    {
        if (!array_key_exists($currencyName, $this->accountCurrencies)) {
            throw new AccountException('Account currency name not found');
        }
        return $this->accountCurrencies[$currencyName];
    }

    public function removeAccount(string $currencyName): void
    {
        if (!array_key_exists($currencyName, $this->accountCurrencies)) {
            throw new AccountException('Account currency name not found');
        }
        unset($this->accountCurrencies[$currencyName]);
    }

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

    public function getSuppliedCurrency(): array
    {
        return array_keys($this->accountCurrencies);
    }

    public function setDefaultCurrency(string $defaultCurrencyName): void
    {
        if (!array_key_exists($defaultCurrencyName, $this->accountCurrencies)) {
            throw new AccountException('Account currency name not found');
        }

        $this->defaultCurrencyName = $defaultCurrencyName;
    }

    public function getDefaultCurrency(): string {
        return $this->defaultCurrencyName;
    }
}