<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\DataObject;

use Pimcore\Model\DataObject;

final class LocalizedField
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
    public static function withFallbackValues(callable $fn, mixed ...$args)
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
    public static function withoutFallbackValues(callable $fn, mixed ...$args)
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
    private static function execute(callable $fn, array $args, bool $fallbackValues)
    {
        $backup = DataObject\Localizedfield::getGetFallbackValues();
        DataObject\Localizedfield::setGetFallbackValues($fallbackValues);

        try {
            return $fn(...$args);
        } finally {
            DataObject\Localizedfield::setGetFallbackValues($backup);
        }
    }
}
