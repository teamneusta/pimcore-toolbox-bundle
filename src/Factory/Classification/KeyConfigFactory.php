<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Factory\Classification;

use Neusta\Pimcore\ToolboxBundle\Repository\Classification\KeyConfigRepository;
use Pimcore\Model\DataObject\ClassDefinition\Data;
use Pimcore\Model\DataObject\Classificationstore\KeyConfig;

class KeyConfigFactory
{
    public function __construct(
        private KeyConfigRepository $repository,
    ) {
    }

    public function create(string $name, string $description, Data $field, int $storeId): KeyConfig
    {
        if (!$keyConfig = $this->repository->getByName($name)) {
            $keyConfig = new KeyConfig();
            $keyConfig->setName($name);
            $keyConfig->setDescription($description);
            $keyConfig->setEnabled(true);
            $keyConfig->setType($field->getFieldtype());
            $fieldDefinition = json_encode($field);
            if (false !== $fieldDefinition) {
                $keyConfig->setDefinition($fieldDefinition);
            }
            $keyConfig->setStoreId($storeId);

            $keyConfig->save();
        }

        return $keyConfig;
    }
}
