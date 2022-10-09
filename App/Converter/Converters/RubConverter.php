<?php
namespace App\Converter\Converters;

use App\Converter\Converter;
use App\Currency\CurrencyData;
use App\Converter\ConverterException;

class RubConverter implements Converter
{
    public function convert(string $toCurrencyName, int $amount, $rate): float
    {
        switch ($toCurrencyName) {
            case CurrencyData::EUR:
                return round($amount / $rate, 2);
                break;
            case CurrencyData::USD:
                return round($amount / $rate, 2);
                break;
            default:
                throw new ConverterException('Currency for exchange not found');
        }
    }
}