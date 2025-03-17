<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Integration\Factory\Classification;

use Neusta\Pimcore\TestingFramework\Database\ResetDatabase;
use Neusta\Pimcore\ToolboxBundle\Factory\Classification\StoreConfigFactory;
use Neusta\Pimcore\ToolboxBundle\Repository\Classification\StoreConfigRepository;
use Pimcore\Model\DataObject\Classificationstore\StoreConfig;
use Pimcore\Test\KernelTestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

class StoreConfigFactoryTest extends KernelTestCase
{
    use ProphecyTrait;
    use ResetDatabase;

    /** @var ObjectProphecy<StoreConfigRepository> */
    private ObjectProphecy $repository;
    private StoreConfig $storeConfig;
    private string $name = 'name';

    protected function setUp(): void
    {
        parent::setUp();

        self::getContainer();

        $this->storeConfig = new StoreConfig();
        $this->storeConfig->setName($this->name);
        $this->storeConfig->save();
    }

    /** @test */
    public function createStoreConfigIfNotAlreadyExists()
    {
        $factory = new StoreConfigFactory($this->getContainer()->get(StoreConfigRepository::class));
        $storeConfig = $factory->createOrLoad($this->storeConfig->getName());
        $this->assertEquals($this->name, $storeConfig->getName());
    }

    /** @test */
    public function createStoreConfigIfAlreadyExists()
    {
        $existingStoreConfig = new StoreConfig();
        $existingStoreConfig->setName($this->storeConfig->getName());
        $existingStoreConfig->save();

        $factory = new StoreConfigFactory($this->getContainer()->get(StoreConfigRepository::class));
        $storeConfig = $factory->createOrLoad($this->storeConfig->getName());
        $this->assertEquals($this->name, $storeConfig->getName());
    }
}
