<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Factory;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class InputFactoryTest extends TestCase
{
    use ProphecyTrait;

    /** @test */
    public function checkingIfNameAndTitleGetSet(): void
    {
        $name = 'name';
        $title = 'title';

        $inputFactory = new InputFactory();
        $input = $inputFactory->create($name, $title);

        $this->assertEquals($name, $input->getName());
        $this->assertEquals($title, $input->getTitle());
    }
}
