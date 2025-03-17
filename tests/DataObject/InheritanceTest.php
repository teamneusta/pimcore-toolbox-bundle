<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\DataObject;

use Neusta\Pimcore\ToolboxBundle\DataObject\Inheritance;
use PHPUnit\Framework\TestCase;
use Pimcore\Model\DataObject;

class InheritanceTest extends TestCase
{
    /**
     * @test
     */
    public function withInheritedValues_executes_the_callable_with_enabled_inheritance(): void
    {
        DataObject::setGetInheritedValues(false);

        self::assertFalse(DataObject::getGetInheritedValues());
        self::assertTrue(Inheritance::withInheritedValues(static fn () => DataObject::getGetInheritedValues()));
        self::assertFalse(DataObject::getGetInheritedValues());
    }

    /**
     * @test
     */
    public function withInheritedValues_passes_trailing_args_to_the_callable(): void
    {
        $args = [0, 'foo', true, null, [123, 456 => 'bar'], new \stdClass()];

        self::assertSame($args, Inheritance::withInheritedValues(static fn (...$a): array => $a, ...$args));
    }

    /**
     * @test
     */
    public function withoutInheritedValues_executes_the_callable_with_disabled_inheritance(): void
    {
        DataObject::setGetInheritedValues(true);

        self::assertTrue(DataObject::getGetInheritedValues());
        self::assertFalse(Inheritance::withoutInheritedValues(static fn () => DataObject::getGetInheritedValues()));
        self::assertTrue(DataObject::getGetInheritedValues());
    }

    /**
     * @test
     */
    public function withoutInheritedValues_passes_trailing_args_to_the_callable(): void
    {
        $args = [0, 'foo', true, null, [123, 456 => 'bar'], new \stdClass()];

        self::assertSame($args, Inheritance::withoutInheritedValues(static fn (...$a): array => $a, ...$args));
    }
}
