<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\DataObject;

use Neusta\Pimcore\ToolboxBundle\DataObject\LocalizedField;
use PHPUnit\Framework\TestCase;
use Pimcore\Model\DataObject;

class LocalizedFieldTest extends TestCase
{
    /**
     * @test
     */
    public function withFallbackValues_executes_the_callable_with_enabled_inheritance(): void
    {
        DataObject\Localizedfield::setGetFallbackValues(false);

        self::assertFalse(DataObject\Localizedfield::getGetFallbackValues());
        self::assertTrue(LocalizedField::withFallbackValues(static fn () => DataObject\Localizedfield::getGetFallbackValues()));
        self::assertFalse(DataObject\Localizedfield::getGetFallbackValues());
    }

    /**
     * @test
     */
    public function withFallbackValues_passes_trailing_args_to_the_callable(): void
    {
        $args = [0, 'foo', true, null, [123, 456 => 'bar'], new \stdClass()];

        self::assertSame($args, LocalizedField::withFallbackValues(static fn (...$a): array => $a, ...$args));
    }

    /**
     * @test
     */
    public function withoutFallbackValues_executes_the_callable_with_disabled_inheritance(): void
    {
        DataObject\Localizedfield::setGetFallbackValues(true);

        self::assertTrue(DataObject\Localizedfield::getGetFallbackValues());
        self::assertFalse(LocalizedField::withoutFallbackValues(static fn () => DataObject\Localizedfield::getGetFallbackValues()));
        self::assertTrue(DataObject\Localizedfield::getGetFallbackValues());
    }

    /**
     * @test
     */
    public function withoutFallbackValues_passes_trailing_args_to_the_callable(): void
    {
        $args = [0, 'foo', true, null, [123, 456 => 'bar'], new \stdClass()];

        self::assertSame($args, LocalizedField::withoutFallbackValues(static fn (...$a): array => $a, ...$args));
    }
}
