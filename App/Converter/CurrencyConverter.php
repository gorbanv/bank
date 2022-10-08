<?php

namespace App\Converter;

use App\Converter\Converter;


class CurrencyConverter
{
    public Converter $instance;

    public function setConverter(Converter $converter)
    {
        $this->instance = $converter;
    }
}