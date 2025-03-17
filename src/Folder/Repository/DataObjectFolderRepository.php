<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Folder\Repository;

use Neusta\Pimcore\ToolboxBundle\Folder\Exception\CannotCreateFolder;
use Neusta\Pimcore\ToolboxBundle\Folder\Exception\CannotDeleteFolder;
use Pimcore\Model\DataObject;

/**
 * @template-implements FolderRepository<DataObject\Folder>
 */
final class DataObjectFolderRepository implements FolderRepository
{
    public function findByPath(string $path): ?DataObject\Folder
    {
        return DataObject\Folder::getByPath($path);
    }

    public function getOrCreateByPath(string $path): DataObject\Folder
    {
        try {
            $folder = DataObject\Service::createFolderByPath($path);
        } catch (\Throwable $e) {
            throw CannotCreateFolder::becausePathAlreadyExistsButIsNoFolder($path);
        }

        if ($folder instanceof DataObject\Folder) {
            return $folder;
        }

        throw CannotCreateFolder::becausePathAlreadyExistsButIsNoFolder($path);
    }

    public function deleteByPath(string $path): bool
    {
        if (!$folder = DataObject\Folder::getByPath($path)) {
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
        if (!$folder = DataObject\Folder::getByPath($path)) {
            return false;
        }

        $folder->delete();

        return true;
    }
}
