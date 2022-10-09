<?php

namespace App\Accounts;

use App\Currency\{Currency, Rub, Eur, Usd};

class MultiCurrencyAccount
{
    const CURRENCY_RUB = 'RUB';
    const CURRENCY_EUR = 'EUR';
    const CURRENCY_USD = 'USD';

    private string $defaultCurrency;
    private array $accountCurrencies = [];

    public function addCurrency(string $currency)
    {
        if (array_key_exists($currency, $this->accountCurrencies)) {
            throw new Exception('Currency already added');
        }

        switch ($currency) {
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
                throw new Exception('Currency type not found');
        }
    }

    public function deposit(Currency $currency)
    {
        if (!array_key_exists($currency::CURRENCY_NAME, $this->accountCurrencies)) {
            throw new Exception('Currency account not found');
        }

        $this->accountCurrencies[$currency::CURRENCY_NAME]->setBalance(
            $this->accountCurrencies[$currency::CURRENCY_NAME]->getBalance()
            + $currency->getBalance()
        );
    }

    public function withdraw(Currency $currency)
    {
        if (!array_key_exists($currency::CURRENCY_NAME, $this->accountCurrencies)) {
            throw new Exception('Currency account not found');
        }

        $currentBalance = $this->accountCurrencies[$currency::CURRENCY_NAME]->getBalance();
        $withdrawBalance = $currency->getBalance();

        if ($currentBalance < $withdrawBalance ) {
            throw new Exception('Not enough funds in the account');
        }

        $this->accountCurrencies[$currency::CURRENCY_NAME]->setBalance($currentBalance - $withdrawBalance);

        return $this->accountCurrencies[$currency::CURRENCY_NAME];
    }

    public function getBalance(string $currency = null)
    {
        if (!$currency) {
            return $this->accountCurrencies[$this->defaultCurrency]->getBalance();
        } else {
            return $this->accountCurrencies[$currency]->getBalance();
        }
    }

    public function getSuppliedCurrency()
    {
        return array_keys($this->accountCurrencies);
    }

    public function setDefaultCurrency(string $defaultCurrency)
    {
        $this->defaultCurrency = $defaultCurrency;
    }
}