<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Filter\Base;

/**
 * @template TFilteredObject of object
 */
interface Filter
{
    /**
     * @param TFilteredObject[] $objects
     *
     * @return TFilteredObject[]
     */
    public function filter(iterable $objects): iterable;

    /**
     * @param TFilteredObject $object
     */
    public function accept(object $object): bool;
}
