# CountryList

Example:

```php
$repository = new Alcohol\CountryList\CountryList();
$country = $repository->findByCode('nl');
```

Result:

```
Alcohol\CountryList\Country Object
(
    [alpha2] => NL
    [alpha3] => NLD
    [numeric] => 528
    [name] => Netherlands (the)
    [currency] => EUR
)
```
