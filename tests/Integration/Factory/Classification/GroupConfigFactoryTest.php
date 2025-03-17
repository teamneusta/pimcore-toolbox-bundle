<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Integration\Factory\Classification;

use Neusta\Pimcore\TestingFramework\Database\ResetDatabase;
use Neusta\Pimcore\ToolboxBundle\Factory\Classification\GroupConfigFactory;
use Neusta\Pimcore\ToolboxBundle\Repository\Classification\GroupConfigRepository;
use Pimcore\Model\DataObject\Classificationstore\GroupConfig;
use Pimcore\Test\KernelTestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class GroupConfigFactoryTest extends KernelTestCase
{
    use ProphecyTrait;
    use ResetDatabase;

    private GroupConfig $groupConfig;
    private string $name = 'name';
    private string $description = 'Unused description';
    private int $storeId = 3;

    protected function setUp(): void
    {
        parent::setUp();

        self::getContainer();

        $this->groupConfig = new GroupConfig();
        $this->groupConfig->setName($this->name);
        $this->groupConfig->setDescription($this->description);
        $this->groupConfig->setStoreId($this->storeId);
        $this->groupConfig->save();
    }

    /** @test */
    public function createGroupConfigShouldReturnGroupConfig(): void
    {
        $factory = new GroupConfigFactory($this->getContainer()->get(GroupConfigRepository::class));
        $groupConfig = $factory->createOrLoad(
            $this->groupConfig->getName(),
            $this->groupConfig->getDescription(),
            $this->groupConfig->getStoreId()
        );
        $this->assertEquals($this->groupConfig->getName(), $groupConfig->getName());
        $this->assertEquals($this->groupConfig->getDescription(), $groupConfig->getDescription());
        $this->assertEquals($this->groupConfig->getStoreId(), $groupConfig->getStoreId());
    }

    /** @test */
    public function createGroupConfigIfAlreadyExists(): void
    {
        $config = new GroupConfig();
        $config->setName($this->groupConfig->getName());
        $config->setDescription($this->groupConfig->getDescription());
        $config->setStoreId($this->groupConfig->getStoreId());
        $config->save();

        $factory = new GroupConfigFactory($this->getContainer()->get(GroupConfigRepository::class));
        $groupConfig = $factory->createOrLoad(
            $this->groupConfig->getName(),
            $this->groupConfig->getDescription(),
            $this->groupConfig->getStoreId());
        $this->assertEquals($this->groupConfig->getName(), $groupConfig->getName());
        $this->assertEquals($this->groupConfig->getDescription(), $groupConfig->getDescription());
        $this->assertEquals($this->groupConfig->getStoreId(), $groupConfig->getStoreId());
    }
}
