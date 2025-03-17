<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Filter\Pimcore;

use Neusta\Pimcore\ToolboxBundle\Filter\Base\AbstractFilter;
use Pimcore\Model\Element\AbstractElement;

/**
 * @template TFilteredObject of AbstractElement
 *
 * @extends AbstractFilter<TFilteredObject>
 */
class PropertyFilter extends AbstractFilter
{
    public function __construct(
        private string $propertyName,
        private mixed $propertyValue,
        private bool $accepted = true,
    ) {
    }

    public function accept(object $object): bool
    {
        return ($object->getProperty($this->propertyName) === $this->propertyValue) === $this->accepted;
    }
}
