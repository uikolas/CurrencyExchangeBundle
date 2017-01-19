<?php

namespace CurrencyExchangeBundle\Service;

use CurrencyExchangeBundle\CurrencyPair\CurrencyPair;
use CurrencyExchangeBundle\ExchangeRate\ExchangeRate;
use CurrencyExchangeBundle\ExchangeRateProvider\ExchangeRateProviderInterface;
use Psr\Cache\CacheItemInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class ExchangeRateService
{
    /**
     * @var ExchangeRateProviderInterface[]
     */
    private $exchangeRateProviders = [];

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
     * @param CurrencyPair $currencyPair
     * @return ExchangeRate|null
     */
    public function bestExchangeRate(CurrencyPair $currencyPair)
    {
        $cacheBestExchangeRate = $this->cache->getItem('best_exchange_rate');

        if (!$cacheBestExchangeRate->isHit()) {
            $currencyPairRates = $this->getCurrencyPairRates($currencyPair);

            $bestExchangeRate = $this->findBestExchangeRate($currencyPairRates);

            if ($bestExchangeRate) {
                $this->cacheExchangeRate($cacheBestExchangeRate, $bestExchangeRate);
            }
        } else {
            $bestExchangeRate = $cacheBestExchangeRate->get();
        }

        return $bestExchangeRate;
    }

    /**
     * @param CurrencyPair $currencyPair
     * @return ExchangeRate[]
     */
    public function currencyRates(CurrencyPair $currencyPair)
    {
        return $this->getCurrencyPairRates($currencyPair);
    }

    /**
     * @param CurrencyPair $currencyPair
     * @return ExchangeRate[]
     */
    private function getCurrencyPairRates(CurrencyPair $currencyPair)
    {
        $rates = [];

        foreach ($this->exchangeRateProviders as $exchangeRateProvider) {
            try {
                $rate = $exchangeRateProvider->getExchangeRate($currencyPair);

                $rates[] = new ExchangeRate($rate, $exchangeRateProvider);
            } catch (\Exception $exception) {
                //TODO: maybe log, that exchange provider don't have rate?
            }
        }

        return $rates;
    }

    /**
     * @param ExchangeRate $bestExchangeRate
     * @param CacheItemInterface $cacheBestExchangeRate
     */
    private function cacheExchangeRate(
        CacheItemInterface $cacheBestExchangeRate,
        ExchangeRate $bestExchangeRate
    ) {
        $cacheBestExchangeRate->set($bestExchangeRate);
        $cacheLifetimeInHours = $this->cacheLifetime . ' hour';
        $cacheBestExchangeRate->expiresAfter(\DateInterval::createFromDateString($cacheLifetimeInHours));

        $this->cache->save($cacheBestExchangeRate);
    }

    /**
     * @param array $currencyPairRates
     * @return ExchangeRate
     */
    private function findBestExchangeRate($currencyPairRates)
    {
        return array_reduce($currencyPairRates, function (ExchangeRate $a = null, ExchangeRate $b) {
            return  $a && $a->getCurrencyPairRate() < $b->getCurrencyPairRate() ? $a : $b;
        });
    }
}
