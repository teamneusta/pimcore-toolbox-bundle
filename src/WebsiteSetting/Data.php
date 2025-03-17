<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\WebsiteSetting;

use Pimcore\Model\Asset;
use Pimcore\Model\DataObject;
use Pimcore\Model\Document;
use Pimcore\Model\WebsiteSetting as PimcoreWebsiteSetting;

final class Data
{
    private function __construct(
        private readonly string $type,
        private readonly mixed $value,
    ) {
    }

    /**
     * @internal
     */
    public static function fromPimcore(PimcoreWebsiteSetting $websiteSetting): self
    {
        if (!$websiteSetting->getId()) {
            throw new \InvalidArgumentException('Unsaved website setting is not supported.');
        }

        if (!$type = $websiteSetting->getType()) {
            throw new \InvalidArgumentException('Website setting without type is not supported.');
        }

        return new self($type, $websiteSetting->getData());
    }

    public static function bool(?bool $value): self
    {
        return new self('bool', $value);
    }

    public static function text(int|float|string|null $value): self
    {
        return new self('text', $value);
    }

    public static function asset(?Asset $value): self
    {
        return new self('asset', $value ? $value->getId() : null);
    }

    public static function document(?Document $value): self
    {
        return new self('document', $value ? $value->getId() : null);
    }

    public static function object(?DataObject $value): self
    {
        return new self('object', $value ? $value->getId() : null);
    }

    public function type(): string
    {
        return $this->type;
    }

    public function value(): mixed
    {
        return $this->value;
    }
}
