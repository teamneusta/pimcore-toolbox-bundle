<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CommandWithArgumentsAndOptions extends Command
{
    protected function configure(): void
    {
        $this
            ->setDescription('Ein einfacher Symfony-Command mit Argument und Option.')
            ->addArgument(
                'username',
                InputArgument::REQUIRED,
                'Der Name des Benutzers'
            )
            ->addOption(
                'greeting',
                null,
                InputOption::VALUE_OPTIONAL,
                'Eine optionale Begrüßung',
                'Hallo' // Standardwert, falls nicht gesetzt
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Argument abrufen
        $username = $input->getArgument('username');

        // Option abrufen (mit Standardwert)
        $greeting = $input->getOption('greeting');

        // Nachricht ausgeben
        $io->success("{$greeting}, {$username}!");

        return Command::SUCCESS;
    }
}
