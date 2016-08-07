<?php

namespace CurrencyExchangeBundle\ExchangeRateProvider\Provider;

use CurrencyExchangeBundle\ExchangeRateProvider\ExchangeRateProviderInterface;

class SebExchangeRateProvider implements ExchangeRateProviderInterface
{
    /**
     * @return array
     */
    public function getExchangeRates()
    {
        return [
            'EUR' => [
                'USD' => 1.1119,
                'LTL' => 0.200
            ],
            'USD' => [
                'EUR' => 0.001,
                'LTL' => 0.345
            ]
        ];
    }

    /**
     * @return string
     */
    public function getProviderName()
    {
        return 'SEB';
    }
}
