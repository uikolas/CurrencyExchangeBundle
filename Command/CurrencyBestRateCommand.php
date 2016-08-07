<?php

namespace CurrencyExchangeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CurrencyBestRateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('currency:rate:best')
            ->setDescription('Find best exchange rate and provider')
            ->addArgument('currency_from', InputArgument::REQUIRED, 'Currency from.')
            ->addArgument('currency_to', InputArgument::REQUIRED, 'Currency to.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $service = $container->get('currency_exchange.service.currency_exchange_service');

        $currencyFrom = $input->getArgument('currency_from');
        $currencyTo   = $input->getArgument('currency_to');

        $bestCurrencyRate = $service->bestExchangeRate($currencyFrom, $currencyTo);

        $bestRate = $bestCurrencyRate->getBestRate();
        $provider = $bestCurrencyRate->getExchangeRateProvider()->getProviderName();

        $output->writeln('Best exchange: '. $bestRate .' provider: '. $provider);
    }
}