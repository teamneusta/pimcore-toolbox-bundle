<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Asset\Model;

class FileSize
{
    public function __construct(
        public readonly int $size,
        public readonly string $unit,
        public readonly string $shortUnit,
        public readonly int $iecSize,
        public readonly string $iecUnit,
        public readonly string $iecShortUnit,
    ) {
    }
}
