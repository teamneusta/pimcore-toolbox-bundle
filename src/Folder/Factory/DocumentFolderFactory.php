<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Folder\Factory;

use Pimcore\Model\Document;
use Pimcore\Model\Element\AbstractElement;

/**
 * @template-implements FolderFactory<Document, Document\Folder>
 */
final class DocumentFolderFactory implements FolderFactory
{
    /**
     * @param Document|Document\Folder|null $parent
     */
    public function create(string $key, ?AbstractElement $parent = null): Document\Folder
    {
        $folder = new Document\Folder();
        $folder->setParentId($parent?->getId() ?? self::ROOT_ID);
        $folder->setKey($key);

        return $folder;
    }
}
