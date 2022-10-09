<?php

namespace App\Currency;

class CurrencyData
{
    const RUB = 'RUB';
    const EUR = 'EUR';
    const USD = 'USD';

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

    public static function setExchangeRate(String $mainCurrency, String $changeCurrency, float $exchangeRate) {
        self::$exchangeRate[$mainCurrency][$changeCurrency] = $exchangeRate;
        self::$exchangeRate[$changeCurrency][$mainCurrency] = $exchangeRate;
    }
    public static function getExchangeRate(String $currency): array {
        return self::$exchangeRate[$currency];
    }

}
