<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Folder\Factory;

use Pimcore\Model\Element\AbstractElement;

/**
 * @template ElementType of \Pimcore\Model\Asset|\Pimcore\Model\DataObject|\Pimcore\Model\Document
 * @template FolderType of \Pimcore\Model\Asset\Folder|\Pimcore\Model\DataObject\Folder|\Pimcore\Model\Document\Folder
 */
interface FolderFactory
{
    public const ROOT_ID = 1;
    public const ROOT_PATH = '/';

    /**
     * @param ElementType|FolderType|null $parent
     *
     * @return FolderType
     */
    public function create(string $key, ?AbstractElement $parent = null): AbstractElement;
}
