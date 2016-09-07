<?php

namespace CurrencyExchangeBundle\Tests\Service;

use CurrencyExchangeBundle\Exception\NoCurrencyException;
use CurrencyExchangeBundle\ExchangeRate\ExchangeRate;
use CurrencyExchangeBundle\Service\ExchangeRateService;
use CurrencyExchangeBundle\Tests\Fixtures\ExchangeRateProvider\FirstExchangeProvider;
use CurrencyExchangeBundle\Tests\Fixtures\ExchangeRateProvider\SecondExchangeProvider;
use CurrencyExchangeBundle\Tests\Fixtures\ExchangeRateProvider\ThirdExchangeProvider;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class ExchangeRateServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ExchangeRateService $exchangeRateService
     */
    private $exchangeRateService;

    public function setUp()
    {
        parent::setUp();

        $cache = new FilesystemAdapter();
        $cache->clear();

        $this->exchangeRateService = new ExchangeRateService($cache, 3);
        $this->exchangeRateService->setExchangeRateProvider(new FirstExchangeProvider());
        $this->exchangeRateService->setExchangeRateProvider(new SecondExchangeProvider());
        $this->exchangeRateService->setExchangeRateProvider(new ThirdExchangeProvider());
    }

    public function testBestExchangeRate()
    {
        $bestRate = $this->exchangeRateService->bestExchangeRate('EUR', 'LTL');

        $this->assertInstanceOf(ExchangeRate::class, $bestRate);
        $this->assertEquals(0.2, $bestRate->getCurrencyPairRate());
    }

    public function testBestExchangeRateList()
    {
        $currencyRates = $this->exchangeRateService->currencyRates('EUR', 'LTL');

        $this->assertCount(3, $currencyRates);
        $this->assertContainsOnlyInstancesOf(ExchangeRate::class, $currencyRates);
    }

    public function testFromNoCurrencyException()
    {
        $this->setExpectedException(NoCurrencyException::class);

        $this->exchangeRateService->bestExchangeRate('NO', 'LTL');
    }

    public function testToNoCurrencyException()
    {
        $this->setExpectedException(NoCurrencyException::class);

        $this->exchangeRateService->bestExchangeRate('USD', 'NO');
    }
}