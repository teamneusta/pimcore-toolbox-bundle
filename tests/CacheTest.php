<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests;

use Neusta\Pimcore\ToolboxBundle\Cache;
use Pimcore\Test\KernelTestCase;

class CacheTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    /**
     * @test
     */
    public function withEnabledCache_executes_the_callable_with_enabled_cache(): void
    {
        \Pimcore\Cache::disable();

        self::assertFalse(\Pimcore\Cache::isEnabled());
        self::assertTrue(Cache::withEnabledCache(static fn () => \Pimcore\Cache::isEnabled()));
        self::assertFalse(\Pimcore\Cache::isEnabled());
    }

    /**
     * @test
     */
    public function withEnabledCache_passes_trailing_args_to_the_callable(): void
    {
        $args = [0, 'foo', true, null, [123, 456 => 'bar'], new \stdClass()];

        self::assertSame($args, Cache::withEnabledCache(static fn (...$a): array => $a, ...$args));
    }

    /**
     * @test
     */
    public function withoutInheritedValues_executes_the_callable_with_disabled_inheritance(): void
    {
        \Pimcore\Cache::enable();

        self::assertTrue(\Pimcore\Cache::isEnabled());
        self::assertFalse(Cache::withDisabledCache(static fn () => \Pimcore\Cache::isEnabled()));
        self::assertTrue(\Pimcore\Cache::isEnabled());
    }

    /**
     * @test
     */
    public function withoutInheritedValues_passes_trailing_args_to_the_callable(): void
    {
        $args = [0, 'foo', true, null, [123, 456 => 'bar'], new \stdClass()];

        self::assertSame($args, Cache::withDisabledCache(static fn (...$a): array => $a, ...$args));
    }
}
