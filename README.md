TEST TASK 1
# CurrencyExchangeBundle

Description can be found here: [Here](Resources/doc/test_task.md)

## Install

Add these line to composer.json:

```
    [...]
    "require" : {
        [...]
        "uikolas/currency-exchange-bundle" : "master"
    },
    "repositories" : [
        {
            "type" : "vcs",
            "url" : "https://github.com/uikolas/CurrencyExchangeBundle.git"
        }
    ],
    [...]
```

Update composer

Enable bundle in app/AppKernel.php

```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            // ...
            new CurrencyExchangeBundle\CurrencyExchangeBundle(),   
        ];
    }
}
```

## Usage

```
$ bin/console currency:rates from_currency to_currency
```
```
$ bin/console currency:rate:best from_currency to_currency
```

### Config
If you want to set cache life time, change `currency_exchange.cache.cache_lifetime`
value
```yaml
parameters:
    currency_exchange.cache.cache_lifetime: 3 # hours value
```