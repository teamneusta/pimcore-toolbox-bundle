<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Folder\Repository;

use Neusta\Pimcore\ToolboxBundle\Folder\Exception\CannotCreateFolder;
use Neusta\Pimcore\ToolboxBundle\Folder\Exception\CannotDeleteFolder;
use Pimcore\Model\Asset;

/**
 * @template-implements FolderRepository<Asset\Folder>
 */
final class AssetFolderRepository implements FolderRepository
{
    public function findByPath(string $path): ?Asset\Folder
    {
        return Asset\Folder::getByPath($path);
    }

    public function getOrCreateByPath(string $path): Asset\Folder
    {
        try {
            $folder = Asset\Service::createFolderByPath($path);
        } catch (\Throwable $error) {
            throw CannotCreateFolder::becausePathAlreadyExistsButIsNoFolder($path);
        }

        if ($folder instanceof Asset\Folder) {
            return $folder;
        }

        throw CannotCreateFolder::becausePathAlreadyExistsButIsNoFolder($path);
    }

    public function deleteByPath(string $path): bool
    {
        if (!$folder = Asset\Folder::getByPath($path)) {
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
        if (!$folder = Asset\Folder::getByPath($path)) {
            return false;
        }

        $folder->delete();

        return true;
    }
}
