<?php

namespace CurrencyExchangeBundle\Tests\ExchangeRateProvider\Provider;

use CurrencyExchangeBundle\CurrencyPair\CurrencyPair;
use CurrencyExchangeBundle\Exception\NoCurrencyException;
use CurrencyExchangeBundle\ExchangeRateProvider\Provider\FixerExchangeRateProvider;
use Goutte\Client;

class FixerExchangeRateProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FixerExchangeRateProvider
     */
    private $exchangeProvider;

    protected function setUp()
    {
        parent::setUp();

        $client = new Client();

        $this->exchangeProvider = new FixerExchangeRateProvider($client);
    }

    public function testGetExchangeRate()
    {
        $result = $this->exchangeProvider->getExchangeRate(new CurrencyPair('USD', 'EUR'));

        $this->assertNotEmpty($result);
    }

    public function testGetNotExistingExchangeRate()
    {
        $this->setExpectedException(NoCurrencyException::class);

        $this->exchangeProvider->getExchangeRate(new CurrencyPair('AAA', 'EUR'));
    }
}
