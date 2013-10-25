<?php

namespace Alcohol\CountryList;

class Country
{
    /**
     * @var string
     */
    public $alpha2;

    /**
     * @var string
     */
    public $alpha3;

    /**
     * @var string
     */
    public $numeric;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $currency;

    /**
     * @param string $alpha2
     * @param string $alpha3
     * @param string $numeric
     * @param string $name
     * @param string $currency
     */
    public function __construct($alpha2, $alpha3, $numeric, $name, $currency)
    {
        $this->alpha2 = $alpha2;
        $this->alpha3 = $alpha3;
        $this->numeric = $numeric;
        $this->name = $name;
        $this->currency = $currency;
    }
}
