<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Repository;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\Concrete;

/**
 * @method DataObject|null    getById(int $id, array $params = [])
 * @method DataObject|null    getByPath(string $path)
 * @method DataObject\Listing getList(array $config = [])
 * @method void               setGetInheritedValues(bool $getInheritedValues)
 * @method bool               doGetInheritedValues(Concrete $object = null)
 * @method void               setHideUnpublished(bool $hideUnpublished)
 * @method bool               getHideUnpublished()
 * @method bool               doHideUnpublished()
 */
class DataObjectRepository extends AbstractElementRepository
{
    public function __construct()
    {
        parent::__construct(DataObject::class);
    }
}
