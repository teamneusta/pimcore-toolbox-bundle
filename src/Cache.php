<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle;

final class Cache
{
    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // no instances
    }

    /**
     * @template T
     *
     * @param (callable(mixed...): T) $fn
     *
     * @return T
     */
    public static function withEnabledCache(callable $fn, mixed ...$args)
    {
        return self::execute($fn, $args, true);
    }

    /**
     * @template T
     *
     * @param (callable(mixed...): T) $fn
     *
     * @return T
     */
    public static function withDisabledCache(callable $fn, mixed ...$args)
    {
        return self::execute($fn, $args, false);
    }

    /**
     * @template T
     *
     * @param (callable(mixed...): T) $fn
     * @param mixed[]                 $args
     *
     * @return T
     */
    private static function execute(callable $fn, array $args, bool $enableCache)
    {
        $backup = \Pimcore\Cache::isEnabled();
        self::toggleCache($enableCache);

        try {
            return $fn(...$args);
        } finally {
            self::toggleCache($backup);
        }
    }

    private static function toggleCache(bool $enableCache): void
    {
        if ($enableCache) {
            \Pimcore\Cache::enable();
        } else {
            \Pimcore\Cache::disable();
        }
    }
}
