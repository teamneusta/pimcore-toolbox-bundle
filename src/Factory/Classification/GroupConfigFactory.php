<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Factory\Classification;

use Neusta\Pimcore\ToolboxBundle\Repository\Classification\GroupConfigRepository;
use Pimcore\Model\DataObject\Classificationstore\GroupConfig;

class GroupConfigFactory
{
    public function __construct(
        private GroupConfigRepository $repository,
    ) {
    }

    public function createOrLoad(string $name, string $description, int $storeId): GroupConfig
    {
        if (!$groupConfig = $this->repository->getByName($name)) {
            $groupConfig = new GroupConfig();
            $groupConfig->setName($name);
            $groupConfig->setDescription($description);
            $groupConfig->setStoreId($storeId);
            $groupConfig->save();
        }

        return $groupConfig;
    }
}
