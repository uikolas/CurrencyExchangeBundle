<?php

namespace CurrencyExchangeBundle\Tests\Fixtures\ExchangeRateProvider;

use CurrencyExchangeBundle\CurrencyPair\CurrencyPair;
use CurrencyExchangeBundle\ExchangeRateProvider\ExchangeRateProviderInterface;

class FourthExchangeProvider implements ExchangeRateProviderInterface
{
    /**
     * @param CurrencyPair $currencyPair
     * @return float
     */
    public function getExchangeRate(CurrencyPair $currencyPair)
    {
        return 6;
    }

    /**
     * @return string
     */
    public function getProviderName()
    {
        return 'FourthExchangeProvider';
    }
}