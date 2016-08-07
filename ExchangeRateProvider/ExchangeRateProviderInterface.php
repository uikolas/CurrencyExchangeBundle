<?php

namespace CurrencyExchangeBundle\ExchangeRateProvider;

interface ExchangeRateProviderInterface
{
    /**
     * @return array
     */
    public function getExchangeRates();

    /**
     * @return string
     */
    public function getProviderName();
}
