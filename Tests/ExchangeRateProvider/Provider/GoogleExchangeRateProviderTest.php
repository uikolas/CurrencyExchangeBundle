<?php

namespace CurrencyExchangeBundle\Tests\ExchangeRateProvider\Provider;

use CurrencyExchangeBundle\CurrencyPair\CurrencyPair;
use CurrencyExchangeBundle\Exception\NoCurrencyException;
use CurrencyExchangeBundle\ExchangeRateProvider\Provider\GoogleExchangeRateProvider;

class GoogleExchangeRateProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GoogleExchangeRateProvider
     */
    private $exchangeProvider;

    protected function setUp()
    {
        parent::setUp();

        $this->exchangeProvider = new GoogleExchangeRateProvider();
    }

    public function testGetExchangeRate()
    {
        $result = $this->exchangeProvider->getExchangeRate(new CurrencyPair('USD', 'EUR'));

        $this->assertNotEmpty($result);
    }

    public function testGetNotExistingExchangeRate()
    {
        $this->setExpectedException(NoCurrencyException::class);

        $result = $this->exchangeProvider->getExchangeRate(new CurrencyPair('AAA', 'EUR'));
    }
}
