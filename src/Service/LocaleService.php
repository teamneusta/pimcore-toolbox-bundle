<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Service;

use Neusta\Pimcore\ToolboxBundle\Wrapper\Admin;
use Neusta\Pimcore\ToolboxBundle\Wrapper\Tool;
use Symfony\Component\HttpFoundation\RequestStack;

class LocaleService
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly Tool $pimcoreTool,
        private readonly Admin $pimcoreToolAdmin,
        private readonly string $defaultLocale,
    ) {
    }

    public function getLocaleByRequest(): string
    {
        $locale = $this->requestStack->getMainRequest()?->getLocale();

        if ($locale && $this->pimcoreTool->isValidLanguage($locale)) {
            return $locale;
        }

        return $this->pimcoreTool->getDefaultLanguage() ?? $this->defaultLocale;
    }

    public function getLocaleByAdminUser(): string
    {
        $locale = $this->pimcoreToolAdmin->getCurrentUserLanguage();

        if ($locale && $this->pimcoreTool->isValidLanguage($locale)) {
            return $locale;
        }

        return $this->pimcoreTool->getDefaultLanguage() ?? $this->defaultLocale;
    }
}
