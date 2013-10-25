<?php

namespace Alcohol\CountryList;

use Alcohol\CountryList\Country;

final class CountryList
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
            $json = json_decode(file_get_contents(__DIR__.'/../../../data/countries.json'), true);
            $countries = array();
            foreach ($json as $country) {
                $countries[$country['code']] = $country;
            }
        }

        $this->countries = $countries;
    }

    /**
     * @param string $code
     * @return Country
     */
    public function findByCode($code)
    {
        $code = strtoupper($code);

        if (false === array_key_exists($code, $this->countries)) {
            return false;
        }

        return new Country(
            $this->countries[$code]['code'],
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
                    $country['code'],
                    $country['name'],
                    $country['currency']
                );
            },
            $this->countries
        );
    }
}
