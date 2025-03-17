<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Factory;

use Pimcore\Model\DataObject\ClassDefinition\Data\Input;

class InputFactory
{
    public function create(string $name, string $title): Input
    {
        $input = new Input();
        $input->setName($name);
        $input->setTitle($title);

        return $input;
    }
}
