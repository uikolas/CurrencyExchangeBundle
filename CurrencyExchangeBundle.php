<?php

namespace CurrencyExchangeBundle;

use CurrencyExchangeBundle\DependencyInjection\Compiler\ExchangeRateProviderCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CurrencyExchangeBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ExchangeRateProviderCompilerPass());
    }

}
