<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests;

use Neusta\Pimcore\ToolboxBundle\Versioning;
use PHPUnit\Framework\TestCase;
use Pimcore\Model\Version;

class VersioningTest extends TestCase
{
    /**
     * @test
     */
    public function withVersioning_executes_the_callable_with_enabled_versioning(): void
    {
        Version::disable();

        self::assertTrue(Version::$disabled);
        self::assertFalse(Versioning::withVersioning(static fn () => Version::$disabled));
        self::assertTrue(Version::$disabled);
    }

    /**
     * @test
     */
    public function withVersioning_passes_trailing_args_to_the_callable(): void
    {
        $args = [0, 'foo', true, null, [123, 456 => 'bar'], new \stdClass()];

        self::assertSame($args, Versioning::withVersioning(static fn (...$a): array => $a, ...$args));
    }

    /**
     * @test
     */
    public function withoutVersioning_executes_the_callable_with_disabled_versioning(): void
    {
        Version::enable();

        self::assertFalse(Version::$disabled);
        self::assertTrue(Versioning::withoutVersioning(static fn () => Version::$disabled));
        self::assertFalse(Version::$disabled);
    }

    /**
     * @test
     */
    public function withoutVersioning_passes_trailing_args_to_the_callable(): void
    {
        $args = [0, 'foo', true, null, [123, 456 => 'bar'], new \stdClass()];

        self::assertSame($args, Versioning::withoutVersioning(static fn (...$a): array => $a, ...$args));
    }
}
