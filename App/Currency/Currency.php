<?php
namespace App\Currency;

use App\Currency\CurrencyData;
use App\Converter\CurrencyConverter;

abstract class Currency
{
    private $amount;

    public function __construct($amount = 0) {
        $this->amount = 0;
        if (is_numeric($amount)) {
            $this->amount = $amount;
        }
        else if ($amount instanceof Currency) {
            $this->amount += $this->convertCurrency($amount);
        }
    }

    public function getBalance(): float {
        return $this->amount;
    }

    public function setBalance(float $amount) {
        $this->amount = $amount;
    }

    public function convertCurrency(Currency $currency): float {

        if (static::CURRENCY_NAME === $currency::CURRENCY_NAME) {
            return $currency->getBalance();
        }

        $converter = new CurrencyConverter();
        $exchangeData = CurrencyData::getExchangeRate(static::CURRENCY_NAME);
        $converter->prepareConverter($currency::CURRENCY_NAME);

        return $converter->instance->convert(
            static::CURRENCY_NAME,
            $currency->getBalance(),
            $exchangeData[$currency::CURRENCY_NAME]
        );
    }

    public static function setExchangeRate(String $exchangeCurrency, float $exchangeRate): void {
        CurrencyData::setExchangeRate(static::CURRENCY_NAME, $exchangeCurrency, $exchangeRate);
    }
}
