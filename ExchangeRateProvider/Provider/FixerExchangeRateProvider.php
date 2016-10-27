<?php

namespace CurrencyExchangeBundle\ExchangeRateProvider\Provider;

use CurrencyExchangeBundle\CurrencyPair\CurrencyPair;
use CurrencyExchangeBundle\Exception\NoCurrencyException;
use CurrencyExchangeBundle\ExchangeRateProvider\ExchangeRateProviderInterface;
use Goutte\Client;

class FixerExchangeRateProvider implements ExchangeRateProviderInterface
{
    /**
     * @param CurrencyPair $currencyPair
     * @return float
     * @throws NoCurrencyException
     */
    public function getExchangeRate(CurrencyPair $currencyPair)
    {
        $currencyFrom = $currencyPair->getFrom();

        $client = new Client();
        $client->request('GET', 'http://api.fixer.io/latest?base='.$currencyFrom);

        $content = $client->getResponse()->getContent();

        $array = json_decode($content, true);

        if (isset($array['error'])) {
            throw new NoCurrencyException($currencyFrom, $this);
        }

        $currencyTo = $currencyPair->getTo();

        if (!isset($array['rates'][$currencyTo])) {
            throw new NoCurrencyException($currencyTo, $this);
        }

        return $array['rates'][$currencyTo];
    }

    /**
     * @return string
     */
    public function getProviderName()
    {
        return 'Fixer.io';
    }
}