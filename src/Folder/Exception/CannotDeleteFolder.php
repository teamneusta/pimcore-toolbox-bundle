<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Folder\Exception;

use Pimcore\Model\Asset;
use Pimcore\Model\DataObject;
use Pimcore\Model\Document;
use Pimcore\Model\Element\AbstractElement;

final class CannotDeleteFolder extends \RuntimeException
{
    /**
     * @param Asset\Folder|DataObject\Folder|Document\Folder $folder
     */
    public static function becauseItHasChildren(AbstractElement $folder): self
    {
        return new self(\sprintf(
            'Cannot delete folder with path "%s" because it has children.',
            $folder->getRealFullPath(),
        ));
    }
}
