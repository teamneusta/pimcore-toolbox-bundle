<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Wrapper;

use Pimcore\SystemSettingsConfig as PimcoreSystemSettingsConfig;

class SystemSettingsConfig
{
    /**
     * @return string[]
     */
    public function getSystemLanguages(): array
    {
        return PimcoreSystemSettingsConfig::get()['general']['valid_languages'] ?? [];
    }
}
