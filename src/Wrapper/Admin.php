<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Wrapper;

class Admin
{
    public function getCurrentUserLanguage(): ?string
    {
        return \Pimcore\Tool\Admin::getCurrentUser()?->getLanguage();
    }
}
