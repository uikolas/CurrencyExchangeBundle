<?php

namespace CurrencyExchangeBundle\ExchangeRate;

use CurrencyExchangeBundle\ExchangeRateProvider\ExchangeRateProviderInterface;

class ExchangeRate
{
    /**
     * @var float
     */
    private $currencyPairRate;

    /**
     * @var ExchangeRateProviderInterface $exchangeRateProvider
     */
    private $exchangeRateProvider;

    /**
     * BestExchangeRate constructor.
     * @param float $currencyPairRate
     * @param ExchangeRateProviderInterface $exchangeRateProvider
     */
    public function __construct($currencyPairRate, ExchangeRateProviderInterface $exchangeRateProvider)
    {
        $this->currencyPairRate     = $currencyPairRate;
        $this->exchangeRateProvider = $exchangeRateProvider;
    }

    /**
     * @return float
     */
    public function getCurrencyPairRate()
    {
        return $this->currencyPairRate;
    }

    /**
     * @param float $currencyPairRate
     */
    public function setCurrencyPairRate($currencyPairRate)
    {
        $this->currencyPairRate = $currencyPairRate;
    }

    /**
     * @return ExchangeRateProviderInterface
     */
    public function getExchangeRateProvider()
    {
        return $this->exchangeRateProvider;
    }

    /**
     * @param ExchangeRateProviderInterface $exchangeRateProvider
     */
    public function setExchangeRateProvider($exchangeRateProvider)
    {
        $this->exchangeRateProvider = $exchangeRateProvider;
    }
}