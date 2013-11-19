<?php

namespace Alcohol\CountryList;

use Alcohol\CountryList\Country;

class CountryList
{
    /**
     * @var array
     */
    protected $countries = array();

    /**
     * @param array $countries
     */
    public function __construct($countries = array())
    {
        if (empty($countries)) {
            $countries = $this->loadFromDataDir();
        }

        $this->countries = $countries;
    }

    /**
     * @return array
     */
    final protected function loadFromDataDir()
    {
        $countries = json_decode(file_get_contents(__DIR__.'/../../../data/countries.json'), true);
        $return = array();
        foreach ($countries as $country) {
            $return[$country['alpha2']] = $country;
        }
        return $return;
    }

    /**
     * @param string $code
     * @return Country
     */
    public function findByCode($code)
    {
        $code = strtoupper($code);

        if (!isset($this->countries[$code])) {
            return false;
        }

        return new Country(
            $this->countries[$code]['alpha2'],
            $this->countries[$code]['alpha3'],
            $this->countries[$code]['numeric'],
            $this->countries[$code]['name'],
            $this->countries[$code]['currency']
        );
    }

    /**
     * @return Country[]
     */
    public function findAll()
    {
        return array_map(
            function ($country) {
                return new Country(
                    $country['alpha2'],
                    $country['alpha3'],
                    $country['numeric'],
                    $country['name'],
                    $country['currency']
                );
            },
            $this->countries
        );
    }
}
