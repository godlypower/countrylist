<?php

namespace Alcohol\CountryList;

class Country
{
    /**
     * @var string
     */
    public $code;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $currency;

    /**
     * @param string $code
     * @param string $name
     * @param string $currency
     */
    public function __construct($code, $name, $currency)
    {
        $this->code = $code;
        $this->name = $name;
        $this->currency = $currency;
    }
}
