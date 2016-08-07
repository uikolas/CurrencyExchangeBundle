<?php

namespace CurrencyExchangeBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ExchangeRateProviderCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('currency_exchange.service.currency_exchange_service')) {
            return;
        }

        $definition     = $container->findDefinition('currency_exchange.service.currency_exchange_service');
        $taggedServices = $container->findTaggedServiceIds('exchange.rate.provider');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('setExchangeRateProvider', [new Reference($id)]);
        }
    }
}