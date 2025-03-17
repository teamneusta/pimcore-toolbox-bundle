<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Filter\Base;

/**
 * @template TFilteredObject of object
 *
 * @extends AbstractCompositeFilter<TFilteredObject>
 */
class OrCompositeFilter extends AbstractCompositeFilter
{
    public function accept(object $object): bool
    {
        if (empty($this->filters)) {
            return true;
        }

        foreach ($this->filters as $filter) {
            if ($filter->accept($object)) {
                return true;
            }
        }

        return false;
    }
}
