<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class BatchCommand extends Command
{
    /** @var array<ArrayInput> */
    private array $commands;

    /**
     * @param list<array{
     *     command: string,
     *     arguments?: array<string, string>,
     *     options?: array<string, string>,
     * }> $commands
     */
    public function __construct(string $name, array $commands)
    {
        parent::__construct($name);

        if ([] === $commands) {
            throw new \InvalidArgumentException("No commands provided in BatchCommand with name: {$name}");
        }

        foreach ($commands as $config) {
            $this->commands[] = new ArrayInput([
                'command' => $config['command'],
                ...$config['arguments'] ?? [],
                ...$config['options'] ?? [],
            ]);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Execute multiple commands');
        $io->section('This command will execute the following commands:');
        $io->listing($this->commands);

        if (!$io->confirm('Do you want to execute these commands?')) {
            return Command::SUCCESS;
        }

        foreach ($this->commands as $command) {
            $io->section('Executing: ' . $command);

            $returnCode = $this->getApplication()
                ?->find($command->getFirstArgument() ?? '')
                ?->run($command, $output)
                ?? Command::INVALID;

            if (Command::SUCCESS !== $returnCode) {
                $io->error("Execution error: {$command}");

                return $returnCode;
            }
        }

        $io->success('All commands executed successfully!');

        return Command::SUCCESS;
    }
}
