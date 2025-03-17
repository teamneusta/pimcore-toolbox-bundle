<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Factory\Classification;

use Neusta\Pimcore\ToolboxBundle\Exception\DataConstraintViolationException;
use Pimcore\Model\DataObject\ClassDefinition\Data;
use Pimcore\Model\DataObject\Classificationstore\GroupConfig;
use Pimcore\Model\DataObject\Classificationstore\KeyConfig;
use Pimcore\Model\DataObject\Classificationstore\StoreConfig;

class ClassificationstoreFactory
{
    public function __construct(
        private KeyConfigFactory $keyConfigFactory,
        private GroupConfigFactory $groupConfigFactory,
        private KeyGroupRelationFactory $keyGroupRelationFactory,
    ) {
    }

    /**
     * @return array{KeyConfig, GroupConfig}
     *
     * @throws DataConstraintViolationException
     */
    public function createNewEntriesForClassificationValues(
        string $keyConfigName,
        Data $field,
        StoreConfig $storeConfig,
        string $createdBy,
    ): array {
        if ($storeConfig->getId()) {
            $keyConfig = $this->keyConfigFactory->create(
                $keyConfigName,
                $createdBy,
                $field,
                $storeConfig->getId(),
            );
            $groupConfig = $this->groupConfigFactory->createOrLoad(
                $keyConfigName,
                $createdBy,
                $storeConfig->getId(),
            );
        } else {
            throw new DataConstraintViolationException('Invalid StoreConfig given.');
        }

        if (!$keyConfig->getId()) {
            throw new DataConstraintViolationException('KeyGroupRelation could not be created because of missing KeyConfig.');
        } elseif (!$groupConfig->getId()) {
            throw new DataConstraintViolationException('KeyGroupRelation could not be created because of missing GroupConfig.');
        }

        $this->keyGroupRelationFactory->createOrLoad(
            $keyConfig->getId(),
            $groupConfig->getId(),
        );

        return [$keyConfig, $groupConfig];
    }
}
