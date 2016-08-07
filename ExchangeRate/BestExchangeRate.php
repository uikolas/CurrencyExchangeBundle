<?php

namespace CurrencyExchangeBundle\ExchangeRate;

use CurrencyExchangeBundle\ExchangeRateProvider\ExchangeRateProviderInterface;

class BestExchangeRate
{
    /**
     * @var float
     */
    private $bestRate;

    /**
     * @var ExchangeRateProviderInterface $exchangeRateProvider
     */
    private $exchangeRateProvider;

    /**
     * BestExchangeRate constructor.
     * @param float $bestRate
     * @param ExchangeRateProviderInterface $exchangeRateProvider
     */
    public function __construct($bestRate, ExchangeRateProviderInterface $exchangeRateProvider)
    {
        $this->bestRate             = $bestRate;
        $this->exchangeRateProvider = $exchangeRateProvider;
    }

    /**
     * @return float
     */
    public function getBestRate()
    {
        return $this->bestRate;
    }

    /**
     * @param float $bestRate
     */
    public function setBestRate($bestRate)
    {
        $this->bestRate = $bestRate;
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