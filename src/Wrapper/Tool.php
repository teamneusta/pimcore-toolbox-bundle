<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Wrapper;

use Pimcore\Mail;
use Pimcore\Model\Element\ElementInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * This class is a wrapper for all static public functions of the \Pimcore\Tool class.
 */
class Tool
{
    /**
     * Checks, if the given language is configured in pimcore's system
     * settings at "Localization & Internationalization (i18n/l10n)".
     *
     * Returns true, if the language is valid or no language is configured at all, false otherwise.
     */
    public function isValidLanguage(string $language): bool
    {
        return \Pimcore\Tool::isValidLanguage($language);
    }

    /**
     * Returns an array of language codes that are configured for this system
     * in pimcore's system settings at "Localization & Internationalization (i18n/l10n)".
     * An empty array is returned if no languages are configured.
     *
     * @return string[]
     */
    public function getValidLanguages(): array
    {
        return \Pimcore\Tool::getValidLanguages();
    }

    /**
     * Returns the default language for this system. If no default is set,
     * returns the first language, or null if no languages are configured
     * at all.
     */
    public function getDefaultLanguage(): ?string
    {
        return \Pimcore\Tool::getDefaultLanguage();
    }

    /**
     * @return array<string, string> Key is the locale, value is the name
     *
     * @throws \Exception
     */
    public function getSupportedLocales(): array
    {
        return \Pimcore\Tool::getSupportedLocales();
    }

    public function isFrontend(?Request $request = null): bool
    {
        return \Pimcore\Tool::isFrontend($request);
    }

    /**
     * e.g., editmode, preview, version preview, always when it is a "frontend-request", but called out of the admin.
     */
    public function isFrontendRequestByAdmin(?Request $request = null): bool
    {
        return \Pimcore\Tool::isFrontendRequestByAdmin($request);
    }

    /**
     * Verify element request (e.g., editmode, preview, version preview) called within admin, with permissions.
     */
    public function isElementRequestByAdmin(Request $request, ElementInterface $element): bool
    {
        return \Pimcore\Tool::isElementRequestByAdmin($request, $element);
    }

    /**
     * Returns the host URL.
     */
    public function getHostUrl(?string $useProtocol = null, ?Request $request = null): string
    {
        return \Pimcore\Tool::getHostUrl($useProtocol, $request);
    }

    /**
     * @param string[]|string|null $recipients
     *
     * @throws \Exception
     */
    public function getMail(array|string|null $recipients = null, ?string $subject = null): Mail
    {
        return \Pimcore\Tool::getMail($recipients, $subject);
    }

    /**
     * @param array<string, mixed> $paramsGet
     * @param array<string, mixed> $paramsPost
     * @param array<string, mixed> $options
     */
    public function getHttpData(string $url, array $paramsGet = [], array $paramsPost = [], array $options = []): bool|string
    {
        return \Pimcore\Tool::getHttpData($url, $paramsGet, $paramsPost, $options);
    }
}
