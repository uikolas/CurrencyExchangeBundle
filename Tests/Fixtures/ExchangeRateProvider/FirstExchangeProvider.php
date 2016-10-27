<?php

namespace CurrencyExchangeBundle\Tests\Fixtures\ExchangeRateProvider;

use CurrencyExchangeBundle\CurrencyPair\CurrencyPair;
use CurrencyExchangeBundle\ExchangeRateProvider\ExchangeRateProviderInterface;

class FirstExchangeProvider implements ExchangeRateProviderInterface
{

    /**
     * @param CurrencyPair $currencyPair
     * @return float
     */
    public function getExchangeRate(CurrencyPair $currencyPair)
    {
        return 0.9;
    }

    /**
     * @return string
     */
    public function getProviderName()
    {
        return 'First provider';
    }
}