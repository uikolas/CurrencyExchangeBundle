<?php

namespace CurrencyExchangeBundle\Service;

use CurrencyExchangeBundle\Exception\NoCurrencyException;
use CurrencyExchangeBundle\ExchangeRate\ExchangeRate;
use CurrencyExchangeBundle\ExchangeRateProvider\ExchangeRateProviderInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class ExchangeRateService
{
    /**
     * @var ExchangeRateProviderInterface[]
     */
    private $exchangeRateProviders;

    /**
     * @var AdapterInterface
     */
    private $cache;

    /**
     * @var int
     */
    private $cacheLifetime;

    /**
     * ExchangeRateService constructor.
     * @param AdapterInterface $cacheAdapter
     * @param int $cacheLifetime
     */
    public function __construct(AdapterInterface $cacheAdapter, $cacheLifetime)
    {
        $this->cache         = $cacheAdapter;
        $this->cacheLifetime = $cacheLifetime;
    }

    /**
     * @param ExchangeRateProviderInterface $exchangeRateProvider
     */
    public function setExchangeRateProvider(ExchangeRateProviderInterface $exchangeRateProvider)
    {
        $this->exchangeRateProviders[] = $exchangeRateProvider;
    }

    /**
     * @param string $from
     * @param string $to
     * @return ExchangeRate
     * @throws NoCurrencyException
     */
    public function bestExchangeRate($from, $to)
    {
        $cacheBestExchangeRate = $this->cache->getItem('best_exchange_rate');

        if (!$cacheBestExchangeRate->isHit()) {
            $bestExchangeRate = $this->getBestExchangeRate($from, $to);

            $cacheBestExchangeRate->set($bestExchangeRate);
            $cacheLifetime = $this->cacheLifetime.' hour';
            $cacheBestExchangeRate->expiresAfter(\DateInterval::createFromDateString($cacheLifetime));

            $this->cache->save($cacheBestExchangeRate);
        } else {
            $bestExchangeRate = $cacheBestExchangeRate->get();
        }

        return $bestExchangeRate;
    }

    /**
     * @param string $from
     * @param string $to
     * @return ExchangeRate[]
     * @throws NoCurrencyException
     */
    public function currencyRates($from, $to)
    {
        $exchangeBestRates = $this->getCurrencyPairRates($from, $to);

        return $exchangeBestRates;
    }

    /**
     * @param string $from
     * @param string $to
     * @return ExchangeRate[]
     * @throws NoCurrencyException
     */
    private function getCurrencyPairRates($from, $to)
    {
        $rates = [];

        foreach ($this->exchangeRateProviders as $exchangeRateProvider) {
            $exchangeRates = $exchangeRateProvider->getExchangeRates();

            if (!isset($exchangeRates[$from])) {
                throw new NoCurrencyException($from, $exchangeRateProvider);
            }

            if (!isset($exchangeRates[$from][$to])) {
                throw new NoCurrencyException($to, $exchangeRateProvider);
            }

            $rate = $exchangeRates[$from][$to];

            $rates[] = new ExchangeRate($rate, $exchangeRateProvider);
        }

        return $rates;
    }

    /**
     * @param string $from
     * @param string $to
     * @return ExchangeRate
     * @throws NoCurrencyException
     */
    private function getBestExchangeRate($from, $to)
    {
        $currencyPairRates = $this->getCurrencyPairRates($from, $to);
        $bestExchangeRate  = $currencyPairRates[0];

        foreach ($currencyPairRates as $currencyRate) {
            if ($currencyRate->getCurrencyPairRate() < $bestExchangeRate->getCurrencyPairRate()) {
                $bestExchangeRate = $currencyRate;
            }
        }

        return $bestExchangeRate;
    }
}
