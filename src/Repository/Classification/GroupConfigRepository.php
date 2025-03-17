<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Repository\Classification;

use Pimcore\Model\DataObject\Classificationstore\GroupConfig;

class GroupConfigRepository
{
    public function getByName(string $name, int $storeId = 1, bool $force = false): ?GroupConfig
    {
        return GroupConfig::getByName($name, $storeId, $force);
    }
}
