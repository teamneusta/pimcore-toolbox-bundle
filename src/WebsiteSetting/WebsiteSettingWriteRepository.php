<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\WebsiteSetting;

interface WebsiteSettingWriteRepository
{
    public function save(WebsiteSetting $websiteSetting): void;

    public function delete(Identifier $identifier): void;
}
