<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Folder\Repository;

use Neusta\Pimcore\ToolboxBundle\Folder\Exception\CannotCreateFolder;
use Neusta\Pimcore\ToolboxBundle\Folder\Exception\CannotDeleteFolder;
use Pimcore\Model\Document;

/**
 * @template-implements FolderRepository<Document\Folder>
 */
final class DocumentFolderRepository implements FolderRepository
{
    public function findByPath(string $path): ?Document\Folder
    {
        return Document\Folder::getByPath($path);
    }

    public function getOrCreateByPath(string $path): Document\Folder
    {
        try {
            $folder = Document\Service::createFolderByPath($path);
        } catch (\Throwable $e) {
            throw CannotCreateFolder::becausePathAlreadyExistsButIsNoFolder($path);
        }

        if ($folder instanceof Document\Folder) {
            return $folder;
        }

        throw CannotCreateFolder::becausePathAlreadyExistsButIsNoFolder($path);
    }

    public function deleteByPath(string $path): bool
    {
        try {
            $folder = Document\Folder::getByPath($path);
        } catch (\Throwable $e) {
            return false;
        }

        if (!$folder) {
            return false;
        }

        if ($folder->hasChildren()) {
            throw CannotDeleteFolder::becauseItHasChildren($folder);
        }

        $folder->delete();

        return true;
    }

    public function deleteWithChildrenByPath(string $path): bool
    {
        try {
            $folder = Document\Folder::getByPath($path);
        } catch (\Throwable $e) {
            return false;
        }

        if (!$folder) {
            return false;
        }

        $folder->delete();

        return true;
    }
}
