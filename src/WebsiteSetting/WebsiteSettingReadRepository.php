<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\WebsiteSetting;

interface WebsiteSettingReadRepository
{
    public function find(Identifier $identifier, ?string $fallbackLanguage = null): ?WebsiteSetting;
}
