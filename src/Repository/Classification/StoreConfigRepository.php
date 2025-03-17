<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Repository\Classification;

use Pimcore\Model\DataObject\Classificationstore\StoreConfig;

class StoreConfigRepository
{
    public function getByName(string $name): ?StoreConfig
    {
        return StoreConfig::getByName($name);
    }
}
