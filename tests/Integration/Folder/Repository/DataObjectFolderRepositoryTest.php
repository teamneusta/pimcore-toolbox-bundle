<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Integration\Folder\Repository;

use Neusta\Pimcore\ToolboxBundle\Folder\Repository\DataObjectFolderRepository;
use Neusta\Pimcore\ToolboxBundle\Folder\Repository\FolderRepository;
use Pimcore\Model\DataObject;

class DataObjectFolderRepositoryTest extends FolderRepositoryTestCase
{
    protected static function createSubject(): FolderRepository
    {
        return new DataObjectFolderRepository();
    }

    protected static function createElement(): DataObject
    {
        return new DataObject();
    }
}
