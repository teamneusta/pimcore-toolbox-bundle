<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Filter\Common;

use Neusta\Pimcore\ToolboxBundle\Filter\Common\PropertyRangeFilter;
use Neusta\Pimcore\ToolboxBundle\Tests\Filter\Model\TestObject;
use PHPUnit\Framework\TestCase;

class PropertyRangeFilterTest extends TestCase
{
    /**
     * @test
     */
    public function checkIsFiltered_regular_true_case(): void
    {
        $testObject = new TestObject();
        $testObject->intValue = 17;

        $filter = new PropertyRangeFilter('intValue', 16, 17);
        $this->assertTrue($filter->accept($testObject));
    }

    /**
     * @test
     */
    public function checkIsFiltered_regular_false_case(): void
    {
        $testObject = new TestObject();
        $testObject->intValue = 18;

        $filter = new PropertyRangeFilter('intValue', 16, 17);
        $this->assertFalse($filter->accept($testObject));
    }

    /**
     * @test
     */
    public function checkIsNotFiltered_regular_false_case(): void
    {
        $testObject = new TestObject();
        $testObject->intValue = 17;

        $filter = new PropertyRangeFilter('intValue', 16, 17, false);
        $this->assertFalse($filter->accept($testObject));
    }

    /**
     * @test
     */
    public function checkIsNotFiltered_regular_true_case(): void
    {
        $testObject = new TestObject();
        $testObject->intValue = 18;

        $filter = new PropertyRangeFilter('intValue', 16, 17, false);
        $this->assertTrue($filter->accept($testObject));
    }
}
