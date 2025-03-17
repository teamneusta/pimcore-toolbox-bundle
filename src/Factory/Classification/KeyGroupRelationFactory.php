<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Factory\Classification;

use Neusta\Pimcore\ToolboxBundle\Repository\Classification\KeyGroupRelationRepository;
use Pimcore\Model\DataObject\Classificationstore\KeyGroupRelation;

class KeyGroupRelationFactory
{
    public function __construct(
        private KeyGroupRelationRepository $repository,
    ) {
    }

    public function createOrLoad(int $keyConfigId, int $groupConfigId): KeyGroupRelation
    {
        if (!$keyGroupRelation = $this->repository->getByGroupAndKeyId($groupConfigId, $keyConfigId)) {
            $keyGroupRelation = new KeyGroupRelation();
            $keyGroupRelation->setKeyId($keyConfigId);
            $keyGroupRelation->setGroupId($groupConfigId);
            $keyGroupRelation->save();
        }

        return $keyGroupRelation;
    }
}
