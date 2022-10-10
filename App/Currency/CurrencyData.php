<?php

namespace App\Currency;

class CurrencyData
{
    // supported currency
    const RUB = 'RUB';
    const EUR = 'EUR';
    const USD = 'USD';

    // exchange pair rate for currency
    private static array $exchangeRate = [
        'EUR' => [
            'USD' => 1,
            'RUB' => 80,
        ],
        'USD' => [
            'EUR' => 1,
            'RUB' => 70,
        ],
        'RUB' => [
            'EUR' => 80,
            'USD' => 70,
        ]
    ];

    /**
     * Set exchange rate for currency pair
     * @param String $mainCurrency - current currency e.g. 'RUB'
     * @param String $changeCurrency - currency pair name for change e.g. 'EUR'
     * @param float $exchangeRate
     * @return void
     */
    public static function setExchangeRate(String $mainCurrency, String $changeCurrency, float $exchangeRate) {
        self::$exchangeRate[$mainCurrency][$changeCurrency] = $exchangeRate;
        self::$exchangeRate[$changeCurrency][$mainCurrency] = $exchangeRate;
    }

    /**
     * Return currency pair exchange rate
     * @param String $currency - current currency e.g. 'RUB'
     * @return array[]
     */
    public static function getExchangeRate(String $currency): array {
        return self::$exchangeRate[$currency];
    }

}
