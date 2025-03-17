<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Integration\Folder\Factory;

use Neusta\Pimcore\TestingFramework\Database\ResetDatabase;
use Neusta\Pimcore\ToolboxBundle\Folder\Factory\DocumentFolderFactory;
use Pimcore\Test\KernelTestCase;

/**
 * @coversDefaultClass \Neusta\Pimcore\ToolboxBundle\Folder\Factory\DocumentFolderFactory
 */
class DocumentFolderFactoryTest extends KernelTestCase
{
    use ResetDatabase;

    private DocumentFolderFactory $subject;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->subject = new DocumentFolderFactory();
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
        $baseFolder->save();

        $subFolder = $this->subject->create('subFolder', $baseFolder);
        self::assertSame($baseFolder->getId(), $subFolder->getParentId());
        self::assertSame('subFolder', $subFolder->getKey());
    }
}
