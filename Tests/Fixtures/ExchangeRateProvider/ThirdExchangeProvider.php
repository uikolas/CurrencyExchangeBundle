<?php

namespace CurrencyExchangeBundle\Tests\Fixtures\ExchangeRateProvider;

use CurrencyExchangeBundle\CurrencyPair\CurrencyPair;
use CurrencyExchangeBundle\ExchangeRateProvider\ExchangeRateProviderInterface;

class ThirdExchangeProvider implements ExchangeRateProviderInterface
{
    /**
     * @param CurrencyPair $currencyPair
     * @return float
     */
    public function getExchangeRate(CurrencyPair $currencyPair)
    {
        return 1.2;
    }

    /**
     * @return string
     */
    public function getProviderName()
    {
        return 'Third provider';
    }
}