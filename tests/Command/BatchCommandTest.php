<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Command;

use Neusta\Pimcore\ToolboxBundle\Command\BatchCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class BatchCommandTest extends TestCase
{
    public function testExecuteAllCommandsSuccessfully(): void
    {
        $application = new Application();
        $application->add(new FakeCommand('my:app:first-command', Command::SUCCESS));
        $application->add(new FakeCommand('my:app:second-command', Command::SUCCESS));
        $application->add(new FakeCommand('my:app:third-command', Command::SUCCESS));

        $batchCommand = new BatchCommand(
            'batch:all',
            [
                ['command' => 'my:app:first-command'],
                ['command' => 'my:app:second-command'],
                ['command' => 'my:app:third-command'],
            ],
        );

        $batchCommand->setApplication($application);

        $commandTester = new CommandTester($batchCommand);
        $commandTester->execute([]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Execute multiple commands', $output);
        $this->assertStringContainsString('All commands executed successfully!', $output);

        $this->assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
    }

    public function testExecuteWithFailingCommand(): void
    {
        $application = new Application();
        $application->add(new FakeCommand('my:app:first-command', Command::SUCCESS));
        $application->add(new FakeCommand('my:app:second-command', Command::FAILURE));
        $application->add(new FakeCommand('my:app:third-command', Command::SUCCESS));

        $batchCommand = new BatchCommand(
            'batch:all',
            [
                ['command' => 'my:app:first-command'],
                ['command' => 'my:app:second-command'],
                ['command' => 'my:app:third-command'],
            ],
        );
        $batchCommand->setApplication($application);

        $commandTester = new CommandTester($batchCommand);
        $commandTester->execute([]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString("Executing: 'my:app:first-command'", $output);
        $this->assertStringContainsString("Execution error: 'my:app:second-command'", $output);
        $this->assertStringNotContainsString("Executing: 'my:app:third-command'", $output);
        $this->assertEquals(Command::FAILURE, $commandTester->getStatusCode());
    }

    public function testExecuteWithCommandArguments(): void
    {
        $application = new Application();
        $application->add(new CommandWithArgumentsAndOptions('my:app:first-command'));
        $application->add(new CommandWithArgumentsAndOptions('my:app:second-command'));
        $application->add(new CommandWithArgumentsAndOptions('my:app:third-command'));

        $batchCommand = new BatchCommand(
            'batch:all',
            [
                [
                    'command' => 'my:app:first-command',
                    'arguments' => ['username' => 'Max'],
                ],
                [
                    'command' => 'my:app:second-command',
                    'arguments' => ['username' => 'Moritz'],
                ],
                [
                    'command' => 'my:app:third-command',
                    'arguments' => ['username' => 'Michael'],
                    'options' => ['--greeting' => 'Servus'],
                ],
            ],
        );
        $batchCommand->setApplication($application);

        $commandTester = new CommandTester($batchCommand);
        $commandTester->execute([]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Hallo, Max!', $output);
        $this->assertStringContainsString('Hallo, Moritz!', $output);
        $this->assertStringContainsString('Servus, Michael!', $output);
        $this->assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
    }

    public function testExecuteWithoutCommands(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('No commands provided in BatchCommand with name: batch:all');

        new BatchCommand('batch:all', []);
    }
}
