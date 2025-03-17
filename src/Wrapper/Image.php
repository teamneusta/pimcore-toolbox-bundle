<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Wrapper;

use Pimcore\Image\Adapter\GD;
use Pimcore\Image\Adapter\Imagick;

/**
 * This class is a wrapper for all static public functions of the \Pimcore\Image class.
 */
class Image
{
    /**
     * @throws \Exception
     */
    public function getInstance(): GD|Imagick|null
    {
        return \Pimcore\Image::getInstance();
    }
}
