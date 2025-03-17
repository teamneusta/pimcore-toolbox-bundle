<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Filter\Common;

use Neusta\Pimcore\ToolboxBundle\Filter\Base\AbstractFilter;

/**
 * @template TFilteredObject of object
 *
 * @extends AbstractFilter<TFilteredObject>
 */
class TypeFilter extends AbstractFilter
{
    /**
     * @param class-string $type
     */
    public function __construct(
        private string $type,
        private bool $accepted = true,
    ) {
    }

    public function accept(object $object): bool
    {
        return ($object instanceof $this->type) === $this->accepted;
    }
}
