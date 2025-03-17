<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Wrapper;

/**
 * This class is a wrapper for all static public functions of the \Pimcore\Config class.
 */
class Config
{
    /**
     * @return array<string, mixed>
     */
    public function getWebsiteConfig(?string $language = null): array
    {
        return \Pimcore\Config::getWebsiteConfig($language);
    }

    /**
     * Returns the whole website config or only a given setting for the current site.
     */
    public function getWebsiteConfigValue(?string $key = null, mixed $default = null, ?string $language = null): mixed
    {
        return \Pimcore\Config::getWebsiteConfigValue($key, $default, $language);
    }

    public function getEnvironment(): string
    {
        return \Pimcore\Config::getEnvironment();
    }
}
