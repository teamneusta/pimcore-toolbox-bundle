<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\WebsiteSetting;

use Pimcore\Model\WebsiteSetting as PimcoreWebsiteSetting;

final class WebsiteSetting
{
    public function __construct(
        private readonly Identifier $identifier,
        private readonly Data $data,
    ) {
    }

    /**
     * @internal
     */
    public static function fromPimcore(PimcoreWebsiteSetting $websiteSetting): self
    {
        return new self(Identifier::fromPimcore($websiteSetting), Data::fromPimcore($websiteSetting));
    }

    public function identifier(): Identifier
    {
        return $this->identifier;
    }

    public function name(): string
    {
        return $this->identifier->name();
    }

    public function siteId(): ?int
    {
        return $this->identifier->siteId();
    }

    public function language(): ?string
    {
        return $this->identifier->language();
    }

    public function data(): Data
    {
        return $this->data;
    }

    public function type(): string
    {
        return $this->data->type();
    }

    public function value(): mixed
    {
        return $this->data->value();
    }
}
