<?php
namespace App\Converter;

use App\Converter\Converter;
use App\Converter\ConverterException;
use App\Converter\Converters\RubConverter;
use App\Converter\Converters\EurConverter;
use App\Converter\Converters\UsdConverter;

class CurrencyConverter
{
    private Converter $instance;

    public function setConverter(Converter $converter): void
    {
        $this->instance = $converter;
    }

    public function getConverter(): Converter
    {
        return $this->instance;
    }

    public function prepareConverter(string $fromName): void
    {
        switch ($fromName) {
            case 'RUB';
                $this->setConverter(new RubConverter());
                break;
            case 'EUR';
                $this->setConverter(new EurConverter());
                break;
            case 'USD';
                $this->setConverter(new UsdConverter());
                break;
            default:
                throw new ConverterException('Currency converter not found');
        }
    }
}