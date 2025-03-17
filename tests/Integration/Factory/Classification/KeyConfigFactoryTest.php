<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Integration\Factory\Classification;

use Neusta\Pimcore\TestingFramework\Database\ResetDatabase;
use Neusta\Pimcore\ToolboxBundle\Factory\Classification\KeyConfigFactory;
use Neusta\Pimcore\ToolboxBundle\Factory\InputFactory;
use Neusta\Pimcore\ToolboxBundle\Repository\Classification\KeyConfigRepository;
use Pimcore\Model\DataObject\ClassDefinition\Data\Input;
use Pimcore\Test\KernelTestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class KeyConfigFactoryTest extends KernelTestCase
{
    use ProphecyTrait;
    use ResetDatabase;

    private Input $data;

    protected function setUp(): void
    {
        parent::setUp();

        self::getContainer();

        $this->data = (new InputFactory())->create('inputName', 'inputTitle');
    }

    /** @test */
    public function creatKey(): void
    {
        $name = 'name';
        $description = 'beschreibung';
        $storeId = 1;

        $keyConfigFactory = new KeyConfigFactory($this->getContainer()->get(KeyConfigRepository::class));
        $keyConfig = $keyConfigFactory->create($name, $description, $this->data, $storeId);
        self::assertEquals($this->data->getTitle(), $keyConfig->getTitle());
    }
}
