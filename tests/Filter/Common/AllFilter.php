<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Filter\Common;

use Neusta\Pimcore\ToolboxBundle\Filter\Base\AbstractFilter;

/**
 * @template TFilteredObject of object
 *
 * @extends AbstractFilter<TFilteredObject>
 */
class AllFilter extends AbstractFilter
{
    public function accept(object $object): bool
    {
        return true;
    }
}
