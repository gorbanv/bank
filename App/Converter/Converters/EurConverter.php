<?php
namespace App\Converter\Converters;

use App\Converter\Converter;
use App\Currency\CurrencyData;
use App\Converter\ConverterException;

class EurConverter implements Converter
{
    /**
     * Convert currency to specify currency
     * @param string $toCurrencyName - currency name for convert to
     * @param int $amount - currency amount
     * @param $rate - exchange rate
     * @return float - converted amount
     * @throws ConverterException
     */
    public function convert(string $toCurrencyName, int $amount, $rate): float {
        switch ($toCurrencyName) {
            case CurrencyData::USD:
                return round($amount / $rate, 2);
                break;
            case CurrencyData::RUB:
                return round($amount * $rate, 2);
                break;
            default:
                throw new ConverterException('Currency for exchange not found');
        }
    }
}
