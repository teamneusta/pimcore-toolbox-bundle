<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Document;

use Pimcore\Model\Document;

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
    public static function withUnpublishedDocuments(callable $fn, mixed ...$args)
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
    public static function withoutUnpublishedDocuments(callable $fn, mixed ...$args)
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
        $backup = Document::doHideUnpublished();
        Document::setHideUnpublished($hide);

        try {
            return $fn(...$args);
        } finally {
            Document::setHideUnpublished($backup);
        }
    }
}
