<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Wrapper\Model\Asset\Image\Thumbnail;

class Config
{
    /**
     * @throws \Exception
     */
    public function getByName(string $name): ?\Pimcore\Model\Asset\Image\Thumbnail\Config
    {
        return \Pimcore\Model\Asset\Image\Thumbnail\Config::getByName($name);
    }
}
