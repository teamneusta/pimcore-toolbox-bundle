<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Factory\Tag;

use Neusta\Pimcore\ToolboxBundle\Wrapper\Model\Element\Tag;
use Pimcore\Model\Element\Tag as PimcoreTag;

class TagFactory
{
    public function __construct(
        private Tag $tag,
    ) {
    }

    public function createByString(string $tag): ?PimcoreTag
    {
        $tagParts = array_filter(explode('/', $tag), fn ($item) => '' !== $item);

        $parentId = null;
        foreach ($tagParts as $tagPart) {
            $tagElement = $this->tag->getByPath($tagPart);
            if (!$tagElement) {
                $tagElement = new PimcoreTag();
                $tagElement->setName($tagPart);
                if ($parentId) {
                    $tagElement->setParentId($parentId);
                }
                $tagElement->save();
            }
            $parentId = $tagElement->getId();
        }

        return $tagElement ?? null;
    }

    /**
     * @param iterable<string> $tags
     *
     * @return iterable<PimcoreTag>
     */
    public function createByStrings(iterable $tags): iterable
    {
        foreach ($tags as $tag) {
            if ($newTag = $this->createByString($tag)) {
                yield $newTag;
            }
        }
    }
}
