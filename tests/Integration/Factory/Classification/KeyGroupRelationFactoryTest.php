<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Integration\Factory\Classification;

use Neusta\Pimcore\TestingFramework\Database\ResetDatabase;
use Neusta\Pimcore\ToolboxBundle\Factory\Classification\KeyGroupRelationFactory;
use Neusta\Pimcore\ToolboxBundle\Factory\InputFactory;
use Neusta\Pimcore\ToolboxBundle\Repository\Classification\KeyGroupRelationRepository;
use Pimcore\Model\DataObject\Classificationstore\GroupConfig;
use Pimcore\Model\DataObject\Classificationstore\KeyConfig;
use Pimcore\Model\DataObject\Classificationstore\KeyGroupRelation;
use Pimcore\Test\KernelTestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class KeyGroupRelationFactoryTest extends KernelTestCase
{
    use ProphecyTrait;
    use ResetDatabase;

    private GroupConfig $groupConfig;
    private KeyConfig $keyConfig;
    private KeyGroupRelation $keyGroupRelation;

    protected function setUp(): void
    {
        parent::setUp();

        self::getContainer();

        $this->groupConfig = new GroupConfig();
        $this->groupConfig->save();

        $this->keyConfig = new KeyConfig();
        $this->keyConfig->setDefinition(json_encode((new InputFactory())->create('inputName', 'inputTitle')));
        $this->keyConfig->save();
    }

    /** @test */
    public function createKeyGroupRelationIfAlreadyExists(): void
    {
        $this->keyGroupRelation = new KeyGroupRelation();
        $this->keyGroupRelation->setKeyId($this->keyConfig->getId());
        $this->keyGroupRelation->setGroupId($this->groupConfig->getId());
        $this->keyGroupRelation->save();

        $keyGroup = new KeyGroupRelationFactory($this->getContainer()->get(KeyGroupRelationRepository::class));
        $keyGroupRelation = $keyGroup->createOrLoad($this->keyConfig->getId(), $this->groupConfig->getId());
        $this->assertEquals($this->keyConfig->getId(), $keyGroupRelation->getKeyId());
        $this->assertEquals($this->groupConfig->getId(), $keyGroupRelation->getGroupId());
    }

    /** @test */
    public function createKeyGroupRelationIfNotExists(): void
    {
        $keyGroup = new KeyGroupRelationFactory($this->getContainer()->get(KeyGroupRelationRepository::class));
        $keyGroupRelation = $keyGroup->createOrLoad($this->keyConfig->getId(), $this->groupConfig->getId());
        $this->assertEquals($this->keyConfig->getId(), $keyGroupRelation->getKeyId());
        $this->assertEquals($this->groupConfig->getId(), $keyGroupRelation->getGroupId());
    }
}
