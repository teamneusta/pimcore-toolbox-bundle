<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Wrapper;

use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;

/**
 * This class is a wrapper for all static public functions of the \Pimcore\File class.
 */
class File
{
    /**
     * @return resource|null
     */
    public function getContext()
    {
        return \Pimcore\File::getContext();
    }

    /**
     * @param resource $context
     */
    public function setContext($context): void
    {
        \Pimcore\File::setContext($context);
    }

    public function getLocalTempFilePath(?string $fileExtension = null, bool $keep = false): string
    {
        return \Pimcore\File::getLocalTempFilePath($fileExtension, $keep);
    }

    /**
     * @throws FilesystemException
     */
    public function recursiveDeleteEmptyDirs(FilesystemOperator $storage, string $storagePath): void
    {
        \Pimcore\File::recursiveDeleteEmptyDirs($storage, $storagePath);
    }
}
