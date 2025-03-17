<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Integration\Filter;

use Neusta\Pimcore\TestingFramework\Database\ResetDatabase;
use Neusta\Pimcore\ToolboxBundle\Filter\Common\CallableFilter;
use Neusta\Pimcore\ToolboxBundle\Filter\Common\PropertyPatternFilter;
use Pimcore\Model\Document\Editable\Input;
use Pimcore\Model\Document\Page;
use Pimcore\Test\KernelTestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class FiltersTest extends KernelTestCase
{
    use ProphecyTrait;
    use ResetDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
    }

    public function testPublishedFilters(): void
    {
        $document = new Page();
        $document->setPublished(true);
        $document->setProperty('internal_page', 'checkbox', true);

        $publishedFilter = self::getContainer()->get('test.toolbox.filter.published');
        self::assertTrue($publishedFilter->accept($document));

        $unpublishedFilter = self::getContainer()->get('test.toolbox.filter.unpublished');
        self::assertFalse($unpublishedFilter->accept($document));

        $internalFilter = self::getContainer()->get('test.toolbox.pimcore.filter.property.internal_page');
        self::assertTrue($internalFilter->accept($document));

        $pageTypeFilter = self::getContainer()->get('test.toolbox.pimcore.filter.type.page');
        self::assertTrue($pageTypeFilter->accept($document));

        $mySpecialFilter = self::getContainer()->get('test.filter.internal.published.page');
        self::assertTrue($mySpecialFilter->accept($document));
    }

    public function testPropertyPatternFilter(): void
    {
        $document = new Page();
        $editable1 = new Input();
        $editable1->setName('xyz');
        $editable2 = new Input();
        $editable2->setName('abc');

        $document->setEditables([$editable1, $editable2]);

        $filter = new PropertyPatternFilter(
            'name',
            '/[xyz]{3}/',
        );

        self::assertEquals([$editable1], iterator_to_array($filter->filter($document->getEditables())));
    }

    public function testCallableFilter(): void
    {
        $document = new Page();

        $checkEvenIdFilter = new CallableFilter(
            fn ($item) => 0 === $item->getId() % 2,
        );

        $document->setId(12);
        self::assertTrue($checkEvenIdFilter->accept($document));

        $document->setId(13);
        self::assertFalse($checkEvenIdFilter->accept($document));
    }
}
