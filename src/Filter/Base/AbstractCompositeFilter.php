<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Filter\Base;

/**
 * @template TFilteredObject of object
 *
 * @extends AbstractFilter<TFilteredObject>
 */
abstract class AbstractCompositeFilter extends AbstractFilter
{
    /**
     * @param list<Filter<TFilteredObject>> $filters
     */
    public function __construct(
        protected array $filters = [],
    ) {
    }

    /**
     * @param Filter<TFilteredObject> $filter
     */
    public function addFilter(Filter $filter): void
    {
        $this->filters[] = $filter;
    }
}
