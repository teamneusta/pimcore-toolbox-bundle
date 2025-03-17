<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Integration\Folder\Factory;

use Neusta\Pimcore\TestingFramework\Database\ResetDatabase;
use Neusta\Pimcore\ToolboxBundle\Folder\Factory\AssetFolderFactory;
use Pimcore\Test\KernelTestCase;

/**
 * @coversDefaultClass \Neusta\Pimcore\ToolboxBundle\Folder\Factory\AssetFolderFactory
 */
class AssetFolderFactoryTest extends KernelTestCase
{
    use ResetDatabase;

    private AssetFolderFactory $subject;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->subject = new AssetFolderFactory();
    }

    /**
     * @test
     *
     * @covers ::create
     */
    public function create(): void
    {
        $baseFolder = $this->subject->create('baseFolder');
        self::assertSame(1, $baseFolder->getParentId());
        self::assertSame('baseFolder', $baseFolder->getKey());

        $subFolder = $this->subject->create('subFolder', $baseFolder);
        self::assertNotNull($subFolder->getParentId());
        self::assertSame('subFolder', $subFolder->getKey());
    }
}
