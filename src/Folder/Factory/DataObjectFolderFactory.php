<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Folder\Factory;

use Pimcore\Model\DataObject;
use Pimcore\Model\Element\AbstractElement;

/**
 * @template-implements FolderFactory<DataObject, DataObject\Folder>
 */
final class DataObjectFolderFactory implements FolderFactory
{
    /**
     * @param DataObject|DataObject\Folder|null $parent
     */
    public function create(string $key, ?AbstractElement $parent = null): DataObject\Folder
    {
        $folder = new DataObject\Folder();
        $folder->setParentId($parent?->getId() ?? self::ROOT_ID);
        $folder->setKey($key);

        return $folder;
    }
}
