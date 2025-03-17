<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Factory\Classification;

use Neusta\Pimcore\ToolboxBundle\Repository\Classification\StoreConfigRepository;
use Pimcore\Model\DataObject\Classificationstore\StoreConfig;

class StoreConfigFactory
{
    public function __construct(
        private StoreConfigRepository $repository,
    ) {
    }

    public function createOrLoad(string $name): StoreConfig
    {
        if (!$classificationstoreVariants = $this->repository->getByName($name)) {
            $classificationstoreVariants = new StoreConfig();
            $classificationstoreVariants->setName($name);
            $classificationstoreVariants->save();
        }

        return $classificationstoreVariants;
    }
}
