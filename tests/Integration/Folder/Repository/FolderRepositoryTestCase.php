<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Integration\Folder\Repository;

use Neusta\Pimcore\TestingFramework\Database\ResetDatabase;
use Neusta\Pimcore\ToolboxBundle\Folder\Exception\CannotCreateFolder;
use Neusta\Pimcore\ToolboxBundle\Folder\Exception\CannotDeleteFolder;
use Neusta\Pimcore\ToolboxBundle\Folder\Repository\FolderRepository;
use Pimcore\Model\Asset;
use Pimcore\Model\DataObject\AbstractObject;
use Pimcore\Model\Document;
use Pimcore\Model\Element\AbstractElement;
use Pimcore\Test\KernelTestCase;

abstract class FolderRepositoryTestCase extends KernelTestCase
{
    use ResetDatabase;

    protected FolderRepository $subject;

    protected function setUp(): void
    {
        $this->subject = static::createSubject();
        self::bootKernel();
    }

    /**
     * @test
     */
    public function getOrCreateByPath_creates_parents_as_necessary(): void
    {
        $fullPath = '/Some/Deep/Path/TestFolder';
        $paths = array_reduce(
            array_filter(explode('/', $fullPath)),
            static fn (array $paths, string $part) => [...$paths, ($paths ? $paths[array_key_last($paths)] : '') . '/' . $part],
            [],
        );

        foreach ($paths as $path) {
            $this->assertFolderNotExists($path);
        }

        $this->subject->getOrCreateByPath($fullPath);

        foreach ($paths as $path) {
            $this->assertFolderExists($path);
        }
    }

    /**
     * @test
     */
    public function getOrCreateByPath_returns_the_same_instance_if_folder_already_exists(): void
    {
        $path = '/TestFolder';

        self::assertSame(
            $this->subject->getOrCreateByPath($path),
            $this->subject->getOrCreateByPath($path),
        );
    }

    /**
     * @test
     */
    public function getOrCreateByPath_throws_if_another_element_already_exists_at_given_path(): void
    {
        $fullPath = '/Parent/Test';
        $path = \dirname($fullPath);
        $key = basename($fullPath);

        // Create an Element at the given path
        $parent = $this->subject->getOrCreateByPath($path);
        $folder = static::createElement()->setParentId($parent->getId() ?? 0)->setKey($key)->save();

        self::assertNotNull($folder);

        $this->expectException(CannotCreateFolder::class);
        $this->expectExceptionMessage('path already exists');

        $this->subject->getOrCreateByPath($fullPath);
    }

    /**
     * @test
     */
    public function deleteByPath(): void
    {
        $path = '/TestFolder';

        $this->subject->getOrCreateByPath($path);
        $this->assertFolderExists($path);

        $this->subject->deleteByPath($path);
        $this->assertFolderNotExists($path);
    }

    /**
     * @test
     */
    public function deleteByPath_handles_non_existing_folders(): void
    {
        $path = '/TestFolder';

        $this->assertFolderNotExists($path);

        self::assertFalse($this->subject->deleteByPath($path));
    }

    /**
     * @test
     */
    public function deleteByPath_does_not_delete_other_elements_at_given_path(): void
    {
        $fullPath = '/Parent/Test';
        $path = \dirname($fullPath);
        $key = basename($fullPath);

        // Create an Element at the given path
        $parent = $this->subject->getOrCreateByPath($path);
        $newElement = static::createElement()->setParentId($parent->getId() ?? 0)->setKey($key)->save();

        self::assertNotNull($newElement);

        self::assertFalse($this->subject->deleteByPath($fullPath));
    }

    /**
     * @test
     */
    public function deleteByPath_throws_if_folder_has_children(): void
    {
        $fullPath = '/TestFolder/SubFolder';
        $path = \dirname($fullPath);

        $this->subject->getOrCreateByPath($fullPath);
        $this->assertFolderExists($fullPath);

        $this->expectException(CannotDeleteFolder::class);
        $this->subject->deleteByPath($path);
    }

    /**
     * @test
     */
    public function deleteWithChildrenByPath(): void
    {
        $fullPath = '/TestFolder/SubFolder';
        $path = \dirname($fullPath);

        $this->subject->getOrCreateByPath($fullPath);
        $this->assertFolderExists($fullPath);

        $this->subject->deleteWithChildrenByPath($path);
        $this->assertFolderNotExists($path);
        $this->assertFolderNotExists($fullPath);
    }

    /**
     * @test
     */
    public function deleteWithChildrenByPath_does_not_delete_other_elements_at_given_path(): void
    {
        $fullPath = '/Parent/Test';
        $path = \dirname($fullPath);
        $key = basename($fullPath);

        // Create an Element at the given path
        $parent = $this->subject->getOrCreateByPath($path);
        $newElement = static::createElement()->setParentId($parent->getId() ?? 0)->setKey($key)->save();

        self::assertNotNull($newElement);

        self::assertFalse($this->subject->deleteWithChildrenByPath($fullPath));
    }

    abstract protected static function createSubject(): FolderRepository;

    abstract protected static function createElement(): AbstractElement;

    protected function assertElementExists(string $path): void
    {
        if (
            static::createElement() instanceof AbstractObject
            || static::createElement() instanceof Asset
            || static::createElement() instanceof Document
        ) {
            self::assertNotNull(static::createElement()::getByPath($path));
        }
    }

    protected function assertElementNotExists(string $path): void
    {
        if (
            static::createElement() instanceof AbstractObject
            || static::createElement() instanceof Asset
            || static::createElement() instanceof Document
        ) {
            self::assertNull(static::createElement()::getByPath($path));
        }
    }

    protected function assertFolderExists(string $path): void
    {
        self::assertNotNull($this->subject->findByPath($path));
    }

    protected function assertFolderNotExists(string $path): void
    {
        self::assertNull($this->subject->findByPath($path));
    }
}
