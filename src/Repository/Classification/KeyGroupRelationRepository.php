<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Repository\Classification;

use Pimcore\Model\DataObject\Classificationstore\KeyGroupRelation;

class KeyGroupRelationRepository
{
    public function getByGroupAndKeyId(int $groupConfigId, int $keyConfigId): ?KeyGroupRelation
    {
        return KeyGroupRelation::getByGroupAndKeyId(
            $groupConfigId,
            $keyConfigId,
        );
    }
}
