<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

final class PimcoreToolboxBundle extends AbstractPimcoreBundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
