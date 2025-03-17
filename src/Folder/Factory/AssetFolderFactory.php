<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Folder\Factory;

use Pimcore\Model\Asset;
use Pimcore\Model\Element\AbstractElement;

/**
 * @template-implements FolderFactory<Asset, Asset\Folder>
 */
final class AssetFolderFactory implements FolderFactory
{
    /**
     * @param Asset|Asset\Folder|null $parent
     */
    public function create(string $key, ?AbstractElement $parent = null): Asset\Folder
    {
        $folder = new Asset\Folder();
        $folder->setKey($key);
        $folder->setParentId($parent?->getId() ?? self::ROOT_ID);

        return $folder;
    }
}
