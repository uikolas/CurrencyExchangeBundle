<?php

namespace CurrencyExchangeBundle\Tests\Service;

use CurrencyExchangeBundle\CurrencyPair\CurrencyPair;
use CurrencyExchangeBundle\ExchangeRate\ExchangeRate;
use CurrencyExchangeBundle\Service\ExchangeRateService;
use CurrencyExchangeBundle\Tests\Fixtures\ExchangeRateProvider\FirstExchangeProvider;
use CurrencyExchangeBundle\Tests\Fixtures\ExchangeRateProvider\FourthExchangeProvider;
use CurrencyExchangeBundle\Tests\Fixtures\ExchangeRateProvider\SecondExchangeProvider;
use CurrencyExchangeBundle\Tests\Fixtures\ExchangeRateProvider\ThirdExchangeProvider;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

class ExchangeRateServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ExchangeRateService $exchangeRateService
     */
    private $exchangeRateService;

    public function setUp()
    {
        parent::setUp();

        $cache = new ArrayAdapter();

        $this->exchangeRateService = new ExchangeRateService($cache, 3);
        $this->exchangeRateService->setExchangeRateProvider(new FirstExchangeProvider());
        $this->exchangeRateService->setExchangeRateProvider(new SecondExchangeProvider());
        $this->exchangeRateService->setExchangeRateProvider(new ThirdExchangeProvider());
        $this->exchangeRateService->setExchangeRateProvider(new FourthExchangeProvider());
    }

    public function testBestExchangeRate()
    {
        $bestRate = $this->exchangeRateService->bestExchangeRate(new CurrencyPair('EUR', 'LTL'));

        $this->assertInstanceOf(ExchangeRate::class, $bestRate);
        $this->assertEquals(0.9, $bestRate->getCurrencyPairRate());
    }

    public function testBestExchangeRateList()
    {
        $currencyRates = $this->exchangeRateService->currencyRates(new CurrencyPair('EUR', 'LTL'));

        $this->assertCount(3, $currencyRates);
        $this->assertContainsOnlyInstancesOf(ExchangeRate::class, $currencyRates);
    }

    public function testNullExchangeRate()
    {
        $cache = new ArrayAdapter();

        $exchangeRateService = new ExchangeRateService($cache, 1);
        $exchangeRateService->setExchangeRateProvider(new SecondExchangeProvider());

        $nullRate = $exchangeRateService->bestExchangeRate(new CurrencyPair('A', 'B'));

        $this->assertNull($nullRate);
    }

    public function testEmptyExchangeRateList()
    {
        $cache = new ArrayAdapter();

        $exchangeRateService = new ExchangeRateService($cache, 1);
        $exchangeRateService->setExchangeRateProvider(new SecondExchangeProvider());

        $emptyCurrencyRates = $exchangeRateService->currencyRates(CurrencyPair::create('A', 'B'));

        $this->assertEmpty($emptyCurrencyRates);
    }
}