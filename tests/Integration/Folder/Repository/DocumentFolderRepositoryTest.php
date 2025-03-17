<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Integration\Folder\Repository;

use Neusta\Pimcore\ToolboxBundle\Folder\Repository\DocumentFolderRepository;
use Neusta\Pimcore\ToolboxBundle\Folder\Repository\FolderRepository;
use Pimcore\Model\Document;

class DocumentFolderRepositoryTest extends FolderRepositoryTestCase
{
    protected static function createSubject(): FolderRepository
    {
        return new DocumentFolderRepository();
    }

    protected static function createElement(): Document
    {
        return new Document();
    }
}
