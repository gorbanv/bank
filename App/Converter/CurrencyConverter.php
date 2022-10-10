<?php
namespace App\Converter;

use App\Converter\Converter;
use App\Converter\ConverterException;
use App\Converter\Converters\RubConverter;
use App\Converter\Converters\EurConverter;
use App\Converter\Converters\UsdConverter;

class CurrencyConverter
{
    // converter instance
    private Converter $instance;

    /**
     * Sets instance converter
     * @param \App\Converter\Converter $converter - converter object
     * @return void
     */
    public function setConverter(Converter $converter): void
    {
        $this->instance = $converter;
    }

    /**
     * Returns instance of selected converter
     * @return \App\Converter\Converter
     */
    public function getConverter(): Converter
    {
        return $this->instance;
    }

    /**
     * Setup converter
     * @param string $fromName - currency name e.g. 'RUB'
     * @return void
     * @throws \App\Converter\ConverterException
     */
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
