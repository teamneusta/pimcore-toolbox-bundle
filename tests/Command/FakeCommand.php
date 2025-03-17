<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FakeCommand extends Command
{
    private int $executionResult;

    public function __construct(string $name, int $executionResult)
    {
        parent::__construct($name);
        $this->executionResult = $executionResult;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return $this->executionResult;
    }
}
