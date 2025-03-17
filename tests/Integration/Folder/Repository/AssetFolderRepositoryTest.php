<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Integration\Folder\Repository;

use Neusta\Pimcore\ToolboxBundle\Folder\Repository\AssetFolderRepository;
use Neusta\Pimcore\ToolboxBundle\Folder\Repository\FolderRepository;
use Pimcore\Model\Asset;

class AssetFolderRepositoryTest extends FolderRepositoryTestCase
{
    protected static function createSubject(): FolderRepository
    {
        return new AssetFolderRepository();
    }

    protected static function createElement(): Asset
    {
        return new Asset();
    }
}
