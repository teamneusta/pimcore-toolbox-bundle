<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Filter\Common;

use Neusta\Pimcore\ToolboxBundle\Filter\Base\AndCompositeFilter;
use Neusta\Pimcore\ToolboxBundle\Filter\Base\OrCompositeFilter;
use Neusta\Pimcore\ToolboxBundle\Filter\Common\PropertyRangeFilter;
use Neusta\Pimcore\ToolboxBundle\Filter\Common\PropertyValueFilter;
use Neusta\Pimcore\ToolboxBundle\Tests\Filter\Model\TestObject;
use PHPUnit\Framework\TestCase;

class CombinedFilterTest extends TestCase
{
    /**
     * @test
     */
    public function checkFilter_regular_and_case(): void
    {
        // Test objects
        $testObject1 = new TestObject();
        $testObject1->value = 'filter_me'; // would be filtered by propertyValueFilter
        $testObject1->intValue = 19;

        $testObject2 = new TestObject();
        $testObject2->value = 'filter_me_not';
        $testObject2->intValue = 18; // would be filtered by propertyRangeFilter

        // Filters to Test
        $propertyValueFilter = new PropertyValueFilter('value', 'filter_me');
        $propertyRangeFilter = new PropertyRangeFilter('intValue', 0, 18);

        $orFilter = new OrCompositeFilter([$propertyValueFilter, $propertyRangeFilter]);
        $andFilter = new AndCompositeFilter([$propertyValueFilter, $propertyRangeFilter]);

        // Assertions
        $this->assertEquals([$testObject1, $testObject2], iterator_to_array($orFilter->filter([$testObject1, $testObject2])));
        $this->assertEmpty(iterator_to_array($andFilter->filter([$testObject1, $testObject2])));

        $this->assertEquals([$testObject1, $testObject2], iterator_to_array((new AllFilter())->filter([$testObject1, $testObject2])));
    }
}
