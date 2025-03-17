<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Filter\Common;

use Neusta\Pimcore\ToolboxBundle\Filter\Base\AbstractFilter;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * @template TFilteredObject of object
 *
 * @extends AbstractFilter<TFilteredObject>
 */
class PropertyPatternFilter extends AbstractFilter
{
    private PropertyAccessorInterface $propertyAccessor;

    public function __construct(
        private string $propertyName,
        private string $propertyPattern,
        private bool $accepted = true,
        ?PropertyAccessorInterface $propertyAccessor = null,
    ) {
        $this->propertyAccessor = $propertyAccessor ?? PropertyAccess::createPropertyAccessor();
    }

    public function accept(object $object): bool
    {
        return (1 === preg_match($this->propertyPattern, $this->propertyAccessor->getValue($object, $this->propertyName))) === $this->accepted;
    }
}
