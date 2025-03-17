<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Integration\Factory\Classification;

use Neusta\Pimcore\TestingFramework\Database\ResetDatabase;
use Neusta\Pimcore\ToolboxBundle\Factory\Classification\ClassificationstoreFactory;
use Neusta\Pimcore\ToolboxBundle\Factory\Classification\GroupConfigFactory;
use Neusta\Pimcore\ToolboxBundle\Factory\Classification\KeyConfigFactory;
use Neusta\Pimcore\ToolboxBundle\Factory\Classification\KeyGroupRelationFactory;
use Neusta\Pimcore\ToolboxBundle\Factory\InputFactory;
use Pimcore\Model\DataObject\ClassDefinition\Data\Input;
use Pimcore\Model\DataObject\Classificationstore\GroupConfig;
use Pimcore\Model\DataObject\Classificationstore\KeyConfig;
use Pimcore\Model\DataObject\Classificationstore\StoreConfig;
use Pimcore\Test\KernelTestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class ClassificationstoreFactoryTest extends KernelTestCase
{
    use ProphecyTrait;
    use ResetDatabase;

    private Input $data;
    private StoreConfig $storeConfig;

    protected function setUp(): void
    {
        parent::setUp();

        self::getContainer();

        $this->data = (new InputFactory())->create('inputName', 'inputTitle');

        $this->storeConfig = new StoreConfig();
        $this->storeConfig->save();
    }

    /** @test */
    public function createNewEntriesForClassificationValues(): void
    {
        $keyConfigName = 'TestName';
        $createdBy = 'createdByTest';

        $classificationstoreFactory = new ClassificationstoreFactory(
            self::getContainer()->get(KeyConfigFactory::class),
            self::getContainer()->get(GroupConfigFactory::class),
            self::getContainer()->get(KeyGroupRelationFactory::class)
        );

        $result = $classificationstoreFactory->createNewEntriesForClassificationValues($keyConfigName, $this->data, $this->storeConfig, $createdBy);

        self::assertInstanceOf(
            KeyConfig::class, $result[0]
        );

        self::assertInstanceOf(
            GroupConfig::class, $result[1]
        );
    }
}
