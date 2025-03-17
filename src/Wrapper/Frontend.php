<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Wrapper;

use Pimcore\Model\Document;
use Pimcore\Model\Site;

class Frontend
{
    public function isDocumentInSite(?Site $site, Document $document): bool
    {
        return \Pimcore\Tool\Frontend::isDocumentInSite($site, $document);
    }

    public function isDocumentInCurrentSite(Document $document): bool
    {
        return \Pimcore\Tool\Frontend::isDocumentInCurrentSite($document);
    }

    public function getSiteForDocument(Document $document): ?Site
    {
        return \Pimcore\Tool\Frontend::getSiteForDocument($document);
    }

    public function getSiteIdForDocument(Document $document): ?int
    {
        return \Pimcore\Tool\Frontend::getSiteIdForDocument($document);
    }

    /**
     * @return false|array{enabled: true, lifetime: int|null}
     */
    public function isOutputCacheEnabled(): bool|array
    {
        return \Pimcore\Tool\Frontend::isOutputCacheEnabled();
    }
}
