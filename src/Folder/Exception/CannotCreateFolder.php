<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Folder\Exception;

final class CannotCreateFolder extends \RuntimeException
{
    public static function becausePathAlreadyExistsButIsNoFolder(string $path): self
    {
        return new self(\sprintf(
            'Cannot create folder with path "%s" because the path already exists (but is no folder).',
            $path,
        ));
    }
}
