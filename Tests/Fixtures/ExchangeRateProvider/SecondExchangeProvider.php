<?php

namespace CurrencyExchangeBundle\Tests\Fixtures\ExchangeRateProvider;

use CurrencyExchangeBundle\CurrencyPair\CurrencyPair;
use CurrencyExchangeBundle\Exception\NoCurrencyException;
use CurrencyExchangeBundle\ExchangeRateProvider\ExchangeRateProviderInterface;

class SecondExchangeProvider implements ExchangeRateProviderInterface
{
    /**
     * @param CurrencyPair $currencyPair
     * @return float
     * @throws NoCurrencyException
     */
    public function getExchangeRate(CurrencyPair $currencyPair)
    {
        throw new NoCurrencyException($currencyPair->getFrom(), $this);
    }

    /**
     * @return string
     */
    public function getProviderName()
    {
        return 'Second Provider';
    }
}