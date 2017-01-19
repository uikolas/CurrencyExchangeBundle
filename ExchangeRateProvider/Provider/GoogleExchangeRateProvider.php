<?php

namespace CurrencyExchangeBundle\ExchangeRateProvider\Provider;

use CurrencyExchangeBundle\CurrencyPair\CurrencyPair;
use CurrencyExchangeBundle\Exception\NoCurrencyException;
use CurrencyExchangeBundle\ExchangeRateProvider\ExchangeRateProviderInterface;
use Goutte\Client;

class GoogleExchangeRateProvider implements ExchangeRateProviderInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * GoogleExchangeRateProvider constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param CurrencyPair $currencyPair
     * @return float
     * @throws NoCurrencyException
     */
    public function getExchangeRate(CurrencyPair $currencyPair)
    {
        $currencyFrom = $currencyPair->getFrom();
        $currencyTo   = $currencyPair->getTo();

        $crawler = $this->client->request('GET', 'https://www.google.com/finance/converter?a=1&from='.$currencyFrom.'&to='.$currencyTo);

        if (!$crawler->filter('#currency_converter_result .bld')->count()) {
            throw new NoCurrencyException($currencyFrom, $this);
        }

        $result = $crawler->filter('#currency_converter_result .bld')->text();

        $amount = explode(' ', $result);

        return $amount[0];
    }

    /**
     * @return string
     */
    public function getProviderName()
    {
        return 'Google';
    }
}