<?php

namespace Alcohol\CountryList\Tests;

use Alcohol\CountryList\CountryList;
use Alcohol\CountryList\Country;

class CountryListTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provider
     */
    public function testFindByCodeReturnsMatchingCountryEntity($repository, $code, $expected)
    {
        $this->assertEquals($expected, $repository->findByCode($code));
    }

    /**
     * @dataProvider provider
     */
    public function testFindByCodeIsCaseInsensitive($repository, $code, $expected)
    {
        $this->assertEquals($expected, $repository->findByCode(strtolower($code)));
    }

    public function testFindAllReturnsAnArrayWithAllCountryEntities()
    {
        $repository = new CountryList($this->countries());
        $this->assertEquals(
            array_map(
                function ($country) {
                    return new Country(
                        $country['alpha2'],
                        $country['alpha3'],
                        $country['numeric'],
                        $country['name'],
                        $country['currency']
                    );
                },
                $this->countries()
            ),
            $repository->findAll()
        );
    }

    public function testNoConstructorArgumentFindsDefaultData()
    {
        $json = json_decode(file_get_contents(__DIR__.'/../../../../data/countries.json'), true);
        $countries = array();
        foreach ($json as $country) {
            $countries[$country['alpha2']] = $country;
        }
        $reflection = new \ReflectionClass('Alcohol\CountryList\CountryList');
        $property = $reflection->getProperty('countries');
        $property->setAccessible(true);
        $repository = new CountryList();
        $this->assertEquals($countries, $property->getValue($repository));
    }

    public function countries()
    {
        return array(
            'NL' => array(
                'alpha2' => 'NL',
                'alpha3' => 'NLD',
                'numeric' => '528',
                'name' => 'Netherlands',
                'currency' => 'EUR'
            ),
            'FR' => array(
                'alpha2' => 'FR',
                'alpha3' => 'FRA',
                'numeric' => '250',
                'name' => 'France',
                'currency' => 'EUR'
            ),
            'GB' => array(
                'alpha2' => 'GB',
                'alpha3' => 'GBR',
                'numeric' => '826',
                'name' => 'United Kingdom',
                'currency' => array(
                    'EUR',
                    'GBP'
                )
            )
        );
    }

    public function provider()
    {
        $countries = $this->countries();
        return array_map(
            function ($country) use ($countries) {
                return array(
                    new CountryList($countries),
                    $country['alpha2'],
                    new Country(
                        $country['alpha2'],
                        $country['alpha3'],
                        $country['numeric'],
                        $country['name'],
                        $country['currency']
                    )
                );
            },
            $countries
        );
    }
}
