<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Factory;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class SelectFactoryTest extends TestCase
{
    use ProphecyTrait;

    /** @test */
    public function checkingIfNameTitleAndOptionsGetSet()
    {
        $name = 'name';
        $title = 'title';
        $options = [];

        $selectFactory = new SelectFactory();
        $actual = $selectFactory->create($name, $title, $options);

        self::assertEquals($name, $actual->getName());
        self::assertEquals($title, $actual->getTitle());
        self::assertEquals($options, $actual->getOptions());
    }
}
