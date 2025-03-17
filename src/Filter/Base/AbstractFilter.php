<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Filter\Base;

/**
 * @template TFilteredObject of object
 *
 * @implements Filter<TFilteredObject>
 */
abstract class AbstractFilter implements Filter
{
    public function filter(iterable $objects): iterable
    {
        foreach ($objects as $object) {
            if ($this->accept($object)) {
                yield $object;
            }
        }
    }

    abstract public function accept(object $object): bool;
}
