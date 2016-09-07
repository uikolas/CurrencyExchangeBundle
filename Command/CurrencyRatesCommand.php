<?php

namespace CurrencyExchangeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CurrencyRatesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('currency:rates')
            ->setDescription('List best providers currency rates')
            ->addArgument('currency_from', InputArgument::REQUIRED, 'Currency from.')
            ->addArgument('currency_to', InputArgument::REQUIRED, 'Currency to.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $service = $container->get('currency_exchange.service.currency_exchange_service');

        $currencyFrom = $input->getArgument('currency_from');
        $currencyTo   = $input->getArgument('currency_to');

        $currencyRates = $service->currencyRates($currencyFrom, $currencyTo);

        $table = new Table($output);

        $table
            ->setHeaders(['Provider', 'Exchange rate']);

        foreach ($currencyRates as $currencyRate) {
            $table->addRow([
                $currencyRate->getExchangeRateProvider()->getProviderName(),
                $currencyRate->getCurrencyPairRate()
            ]);
        }

        $table->render();
    }
}