<?php
namespace App\Accounts;

use App\Currency\Currency;

class MultiCurrencyAccount
{
    public function addCurrency(String $currency) {}
    public function deposit(Currency $currency) {}
    public function withdraw(Currency $currency) {}
    public function getBalance(String $currency = null) {}
    public function getSuppliedCurrency() {}
    public function setDefaultCurrency(String $defaultCurrency) {}
}