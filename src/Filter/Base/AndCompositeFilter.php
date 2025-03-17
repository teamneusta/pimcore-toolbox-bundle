<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Filter\Base;

/**
 * @template TFilteredObject of object
 *
 * @extends AbstractCompositeFilter<TFilteredObject>
 */
class AndCompositeFilter extends AbstractCompositeFilter
{
    public function accept(object $object): bool
    {
        foreach ($this->filters as $filter) {
            if (!$filter->accept($object)) {
                return false;
            }
        }

        return true;
    }
}
