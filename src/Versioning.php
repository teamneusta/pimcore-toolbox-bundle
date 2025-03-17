<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle;

use Pimcore\Model\Version;

class Versioning
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
    public static function withVersioning(callable $fn, mixed ...$args)
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
    public static function withoutVersioning(callable $fn, mixed ...$args)
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
    private static function execute(callable $fn, array $args, bool $enabled)
    {
        $backup = Version::$disabled;

        if ($enabled) {
            Version::enable();
        } else {
            Version::disable();
        }

        try {
            return $fn(...$args);
        } finally {
            if ($backup) {
                Version::disable();
            } else {
                Version::enable();
            }
        }
    }
}
