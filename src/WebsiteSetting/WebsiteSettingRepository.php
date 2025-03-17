<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\WebsiteSetting;

use Pimcore\Model\WebsiteSetting as PimcoreWebsiteSetting;

final class WebsiteSettingRepository implements WebsiteSettingReadRepository, WebsiteSettingWriteRepository
{
    public function find(Identifier $identifier, ?string $fallbackLanguage = null): ?WebsiteSetting
    {
        $websiteSetting = $this->findRaw($identifier, $fallbackLanguage);

        return $websiteSetting ? WebsiteSetting::fromPimcore($websiteSetting) : null;
    }

    public function save(WebsiteSetting $websiteSetting): void
    {
        if (!$setting = $this->findRaw($websiteSetting->identifier())) {
            $setting = new PimcoreWebsiteSetting();
            $setting->setValues([
                'name' => $websiteSetting->name(),
                'siteId' => $websiteSetting->siteId(),
                'language' => $websiteSetting->language() ?? '',
            ]);
        }

        $setting->setValues([
            'type' => $websiteSetting->type(),
            'data' => $websiteSetting->value(),
        ]);

        $setting->save();
    }

    public function delete(Identifier $identifier): void
    {
        $this->findRaw($identifier)?->delete();
    }

    private function findRaw(Identifier $identifier, ?string $fallbackLanguage = null): ?PimcoreWebsiteSetting
    {
        return PimcoreWebsiteSetting::getByName(
            $identifier->name(),
            $identifier->siteId(),
            $identifier->language(),
            $fallbackLanguage,
        );
    }
}
