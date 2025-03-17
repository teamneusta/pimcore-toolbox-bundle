<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Factory;

use Pimcore\Model\DataObject\ClassDefinition\Data\Select;

class SelectFactory
{
    /**
     * @param array<array<string, string>> $options
     */
    public function create(string $name, string $title, array $options): Select
    {
        $select = new Select();
        $select->setName($name);
        $select->setTitle($title);
        $select->setOptions($options);

        return $select;
    }
}
