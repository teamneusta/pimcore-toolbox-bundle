<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\WebsiteSetting;

use Pimcore\Model\WebsiteSetting as PimcoreWebsiteSetting;

final class Identifier
{
    public function __construct(
        private readonly string $name,
        private readonly ?int $siteId,
        private readonly ?string $language,
    ) {
        if ('' === $name) {
            throw new \InvalidArgumentException('Missing website setting name.');
        }
    }

    /**
     * @internal
     */
    public static function fromPimcore(PimcoreWebsiteSetting $websiteSetting): self
    {
        if (!$websiteSetting->getId()) {
            throw new \InvalidArgumentException('Unsaved website setting is not supported.');
        }

        return new self($websiteSetting->getName(), $websiteSetting->getSiteId(), $websiteSetting->getLanguage());
    }

    public function name(): string
    {
        return $this->name;
    }

    public function siteId(): ?int
    {
        return $this->siteId;
    }

    public function language(): ?string
    {
        return $this->language;
    }
}
