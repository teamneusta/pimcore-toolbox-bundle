<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Filter\Common;

use Neusta\Pimcore\ToolboxBundle\Filter\Base\AbstractFilter;

/**
 * @template TFilteredObject of object
 *
 * @extends AbstractFilter<TFilteredObject>
 */
class CallableFilter extends AbstractFilter
{
    /**
     * @param \Closure(TFilteredObject):bool $callable
     */
    public function __construct(
        private \Closure $callable,
        private bool $accepted = true,
    ) {
    }

    public function accept(object $object): bool
    {
        return ($this->callable)($object) === $this->accepted;
    }
}
