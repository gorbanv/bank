<?php
namespace App\Converter\Converters;

use App\Converter\Converter;
use App\Currency\CurrencyData;

class UsdConverter implements Converter
{
    public function convert(string $toCurrencyName, int $amount, $rate): float {

    }
}