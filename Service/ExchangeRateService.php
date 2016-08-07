<?php

namespace CurrencyExchangeBundle\Service;

use CurrencyExchangeBundle\Exception\NoCurrencyException;
use CurrencyExchangeBundle\ExchangeRate\BestExchangeRate;
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
     * @return BestExchangeRate
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
     * @return BestExchangeRate[]
     * @throws NoCurrencyException
     */
    public function currencyRates($from, $to)
    {
        $exchangeBestRates = $this->getExchangeBestRates($from, $to);

        return $exchangeBestRates;
    }

    /**
     * @param string $from
     * @param string $to
     * @return BestExchangeRate[]
     * @throws NoCurrencyException
     */
    private function getExchangeBestRates($from, $to)
    {
        $bestRates = [];

        foreach ($this->exchangeRateProviders as $exchangeRateProvider) {
            $exchangeRates = $exchangeRateProvider->getExchangeRates();

            if (!isset($exchangeRates[$from])) {
                throw new NoCurrencyException($from, $exchangeRateProvider);
            }

            if (!isset($exchangeRates[$from][$to])) {
                throw new NoCurrencyException($to, $exchangeRateProvider);
            }

            $rate = $exchangeRates[$from][$to];

            $bestRates[] = new BestExchangeRate($rate, $exchangeRateProvider);
        }

        return $bestRates;
    }

    /**
     * @param $from
     * @param $to
     * @return BestExchangeRate
     * @throws NoCurrencyException
     */
    private function getBestExchangeRate($from, $to)
    {
        $exchangeBestRates = $this->getExchangeBestRates($from, $to);
        $bestExchangeRate  = $exchangeBestRates[0];

        foreach ($exchangeBestRates as $currencyRate) {
            if ($currencyRate->getBestRate() < $bestExchangeRate->getBestRate()) {
                $bestExchangeRate = $currencyRate;
            }
        }

        return $bestExchangeRate;
    }
}
