<?php

namespace CurrencyExchangeBundle\Tests\ExchangeRateProvider\Provider;

use CurrencyExchangeBundle\CurrencyPair\CurrencyPair;
use CurrencyExchangeBundle\Exception\NoCurrencyException;
use CurrencyExchangeBundle\ExchangeRateProvider\Provider\FixerExchangeRateProvider;

class FixerExchangeRateProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FixerExchangeRateProvider
     */
    private $exchangeProvider;

    protected function setUp()
    {
        parent::setUp();

        $this->exchangeProvider = new FixerExchangeRateProvider();
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
