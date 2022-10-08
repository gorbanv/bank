<?php
namespace App\Converter;

interface Converter
{
    public function convert(string $toCurrencyName, int $amount, float $rate);
}