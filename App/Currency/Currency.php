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

    /**
     * Returns balance of currency
     * @return float
     */
    public function getBalance(): float {
        return $this->amount;
    }

    /**
     * Set balance for currency
     * @param float $amount - currency balance e.g. 100
     * @return void
     */
    public function setBalance(float $amount) {
        $this->amount = $amount;
    }

    /**
     * Convert currency to other currency e.g. Rub to Eur
     * @param Currency $currency
     * @return float
     * @throws \App\Converter\ConverterException
     */
    public function convertCurrency(Currency $currency): float {

        if (static::CURRENCY_NAME === $currency::CURRENCY_NAME) {
            return $currency->getBalance();
        }

        $converter = new CurrencyConverter();
        $exchangeData = CurrencyData::getExchangeRate(static::CURRENCY_NAME);
        $converter->prepareConverter($currency::CURRENCY_NAME);

        return $converter->getConverter()->convert(
            static::CURRENCY_NAME,
            $currency->getBalance(),
            $exchangeData[$currency::CURRENCY_NAME]
        );
    }

    /**
     * Set exchange rate for currency
     * @param String $exchangeCurrency - currency name e.g. 100
     * @param float $exchangeRate - exchange rate e.g. 100
     * @throws \App\Converter\ConverterException
     */
    public static function setExchangeRate(String $exchangeCurrency, float $exchangeRate): void {
        CurrencyData::setExchangeRate(static::CURRENCY_NAME, $exchangeCurrency, $exchangeRate);
    }
}
