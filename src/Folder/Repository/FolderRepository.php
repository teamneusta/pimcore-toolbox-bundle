<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Folder\Repository;

use Neusta\Pimcore\ToolboxBundle\Folder\Exception\CannotCreateFolder;
use Neusta\Pimcore\ToolboxBundle\Folder\Exception\CannotDeleteFolder;
use Pimcore\Model\Element\AbstractElement;

/**
 * @template FolderType of \Pimcore\Model\Asset\Folder|\Pimcore\Model\DataObject\Folder|\Pimcore\Model\Document\Folder
 */
interface FolderRepository
{
    /**
     * @return FolderType|null
     */
    public function findByPath(string $path): ?AbstractElement;

    /**
     * @return FolderType
     *
     * @throws CannotCreateFolder
     */
    public function getOrCreateByPath(string $path): AbstractElement;

    /**
     * @return bool Whether the folder was deleted
     *
     * @throws CannotDeleteFolder
     */
    public function deleteByPath(string $path): bool;

    /**
     * @return bool Whether the folder was deleted
     *
     * @throws CannotDeleteFolder
     */
    public function deleteWithChildrenByPath(string $path): bool;
}
