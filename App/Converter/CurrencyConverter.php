<?php
namespace App\Converter;

use App\Converter\Converter;
use App\Converter\Converters\RubConverter;
use App\Converter\Converters\EurConverter;
use App\Converter\Converters\UsdConverter;

class CurrencyConverter
{
    public Converter $instance;

    public function setConverter(Converter $converter)
    {
        $this->instance = $converter;
    }

    public function prepareConverter(string $fromName)
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
                throw new \Exception('Currency converter not found');
        }
    }
}