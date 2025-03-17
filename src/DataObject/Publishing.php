<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\DataObject;

use Pimcore\Model\DataObject;

final class Publishing
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
    public static function withUnpublishedObjects(callable $fn, mixed ...$args)
    {
        return self::execute($fn, $args, false);
    }

    /**
     * @template T
     *
     * @param (callable(mixed...): T) $fn
     *
     * @return T
     */
    public static function withoutUnpublishedObjects(callable $fn, mixed ...$args)
    {
        return self::execute($fn, $args, true);
    }

    /**
     * @template T
     *
     * @param (callable(mixed...): T) $fn
     * @param mixed[]                 $args
     *
     * @return T
     */
    private static function execute(callable $fn, array $args, bool $hide)
    {
        $backup = DataObject::doHideUnpublished();
        DataObject::setHideUnpublished($hide);

        try {
            return $fn(...$args);
        } finally {
            DataObject::setHideUnpublished($backup);
        }
    }
}
