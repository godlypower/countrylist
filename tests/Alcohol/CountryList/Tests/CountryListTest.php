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
                    return new Country($country['code'], $country['name'], $country['currency']);
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
            $countries[$country['code']] = $country;
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
            'NL' => array('code' => 'NL', 'name' => 'Netherlands', 'currency' => 'EUR'),
            'FR' => array('code' => 'FR', 'name' => 'France', 'currency' => 'EUR'),
            'UK' => array('code' => 'UK', 'name' => 'United Kingdom', 'currency' => array('EUR', 'GBP'))
        );
    }

    public function provider()
    {
        $countries = $this->countries();
        return array_map(
            function ($country) use ($countries) {
                return array(
                    new CountryList($countries),
                    $country['code'],
                    new Country($country['code'], $country['name'], $country['currency'])
                );
            },
            $countries
        );
    }
}
