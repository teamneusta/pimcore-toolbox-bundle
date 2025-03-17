<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Wrapper\Model;

class Site
{
    public function isSiteRequest(): bool
    {
        return \Pimcore\Model\Site::isSiteRequest();
    }
}
