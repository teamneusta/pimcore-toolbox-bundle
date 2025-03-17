<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Filter\Common;

use Neusta\Pimcore\ToolboxBundle\Filter\Common\PropertyValueFilter;
use Neusta\Pimcore\ToolboxBundle\Tests\Filter\Model\TestObject;
use PHPUnit\Framework\TestCase;

class PropertyValueFilterTest extends TestCase
{
    /**
     * @test
     */
    public function checkIsFiltered_regular_true_case(): void
    {
        $testObject = new TestObject();
        $testObject->value = 'my_value';

        $filter = new PropertyValueFilter('value', 'my_value');
        $this->assertTrue($filter->accept($testObject));
    }

    /**
     * @test
     */
    public function checkIsFiltered_regular_false_case(): void
    {
        $testObject = new TestObject();
        $testObject->value = 'my_other_value';

        $filter = new PropertyValueFilter('value', 'my_value');
        $this->assertFalse($filter->accept($testObject));
    }

    /**
     * @test
     */
    public function checkIsNotFiltered_regular_false_case(): void
    {
        $testObject = new TestObject();
        $testObject->value = 'my_value';

        $filter = new PropertyValueFilter('value', 'my_value', false);
        $this->assertFalse($filter->accept($testObject));
    }

    /**
     * @test
     */
    public function checkIsNotFiltered_regular_true_case(): void
    {
        $testObject = new TestObject();
        $testObject->value = 'my_other_value';

        $filter = new PropertyValueFilter('value', 'my_value', false);
        $this->assertTrue($filter->accept($testObject));
    }

    /**
     * @test
     */
    public function checkArray_filtered_case(): void
    {
        $testObject = new TestObject();
        $testObject->value = 'my_value';

        $filter = new PropertyValueFilter('value', 'my_value');
        $this->assertEquals([$testObject], iterator_to_array($filter->filter([$testObject])));
    }

    /**
     * @test
     */
    public function checkArray_not_filtered_case(): void
    {
        $testObject = new TestObject();
        $testObject->value = 'my_other_value';

        $filter = new PropertyValueFilter('value', 'my_value');
        $this->assertEmpty(iterator_to_array($filter->filter([$testObject])));
    }
}
