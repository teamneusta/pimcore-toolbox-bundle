<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Integration\Factory\Tag;

use Neusta\Pimcore\TestingFramework\Database\ResetDatabase;
use Neusta\Pimcore\ToolboxBundle\Factory\Tag\TagFactory;
use Neusta\Pimcore\ToolboxBundle\Wrapper\Model\Element\Tag;
use Pimcore\Model\Element\Tag as PimcoreTag;
use Pimcore\Test\KernelTestCase;

class TagFactoryTest extends KernelTestCase
{
    use ResetDatabase;

    private TagFactory $tagFactory;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();

        $this->tagFactory = new TagFactory(
            new Tag(),
        );
    }

    /** @test */
    public function createByString_regular_case(): void
    {
        $tagElement = $this->tagFactory->createByString('testTag');

        self::assertInstanceOf(PimcoreTag::class, $tagElement);
        self::assertSame('testTag', PimcoreTag::getByPath('testTag')->getName());
    }

    /** @test */
    public function createByString_hierarchy_case(): void
    {
        $tagElement = $this->tagFactory->createByString('/myTags/testTag');

        self::assertInstanceOf(PimcoreTag::class, $tagElement);
        self::assertSame('myTags', PimcoreTag::getByPath('/myTags')->getName());
        self::assertSame('testTag', PimcoreTag::getByPath('/myTags/testTag')->getName());
    }

    /** @test */
    public function createByString_hierarchy_with_zero_tag(): void
    {
        $tagElement = $this->tagFactory->createByString('/myTags/0/testTag');

        self::assertInstanceOf(PimcoreTag::class, $tagElement);
        self::assertSame('myTags', PimcoreTag::getByPath('/myTags')->getName());
        self::assertSame('testTag', PimcoreTag::getByPath('/myTags/0/testTag')->getName());
    }
}
