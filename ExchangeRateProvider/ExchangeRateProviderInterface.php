<?php

namespace CurrencyExchangeBundle\ExchangeRateProvider;

use CurrencyExchangeBundle\CurrencyPair\CurrencyPair;

interface ExchangeRateProviderInterface
{
    /**
     * @param CurrencyPair $currencyPair
     * @return float
     */
    public function getExchangeRate(CurrencyPair $currencyPair);

    /**
     * @return string
     */
    public function getProviderName();
}
