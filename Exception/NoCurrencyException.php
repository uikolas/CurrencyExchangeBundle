<?php

namespace CurrencyExchangeBundle\Exception;

use CurrencyExchangeBundle\ExchangeRateProvider\ExchangeRateProviderInterface;

class NoCurrencyException extends \Exception
{
    /**
     * NoCurrencyException constructor.
     * @param string $currency
     * @param ExchangeRateProviderInterface $provider
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct(
        $currency,
        ExchangeRateProviderInterface $provider,
        $code = 0,
        \Exception $previous = null
    ) {
        $message = sprintf("No '%s' currency found in: '%s' provider", $currency, $provider->getProviderName());

        parent::__construct($message, $code, $previous);
    }
}