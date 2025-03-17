<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Wrapper\Model\Element;

use Pimcore\Model\Element\AbstractElement;

class Tag
{
    public const CTYPE_ASSET = 'asset';
    public const CTYPE_DOCUMENT = 'document';
    public const CTYPE_DATAOBJECT = 'object';

    public function getById(int $id): ?\Pimcore\Model\Element\Tag
    {
        return \Pimcore\Model\Element\Tag::getById($id);
    }

    public function getByPath(string $path): ?\Pimcore\Model\Element\Tag
    {
        return \Pimcore\Model\Element\Tag::getByPath($path);
    }

    /**
     * @return \Pimcore\Model\Element\Tag[]
     */
    public function getTagsForAsset(int $assetId): array
    {
        return $this->getTagsForElement(self::CTYPE_ASSET, $assetId);
    }

    /**
     * @return \Pimcore\Model\Element\Tag[]
     */
    public function getTagsForDocument(int $documentId): array
    {
        return $this->getTagsForElement(self::CTYPE_DOCUMENT, $documentId);
    }

    /**
     * @return \Pimcore\Model\Element\Tag[]
     */
    public function getTagsForObject(int $objectId): array
    {
        return $this->getTagsForElement(self::CTYPE_DATAOBJECT, $objectId);
    }

    /**
     * @return \Pimcore\Model\Element\Tag[]
     */
    public function getTagsForElement(string $cType, int $cId): array
    {
        return \Pimcore\Model\Element\Tag::getTagsForElement($cType, $cId);
    }

    public function addTagToAsset(int $cId, \Pimcore\Model\Element\Tag $tag): void
    {
        \Pimcore\Model\Element\Tag::addTagToElement(self::CTYPE_ASSET, $cId, $tag);
    }

    public function addTagToDocument(int $cId, \Pimcore\Model\Element\Tag $tag): void
    {
        \Pimcore\Model\Element\Tag::addTagToElement(self::CTYPE_DOCUMENT, $cId, $tag);
    }

    public function addTagToObject(int $cId, \Pimcore\Model\Element\Tag $tag): void
    {
        \Pimcore\Model\Element\Tag::addTagToElement(self::CTYPE_DATAOBJECT, $cId, $tag);
    }

    public function addTagToElement(string $cType, int $cId, \Pimcore\Model\Element\Tag $tag): void
    {
        \Pimcore\Model\Element\Tag::addTagToElement($cType, $cId, $tag);
    }

    public function removeTagFromElement(string $cType, int $cId, \Pimcore\Model\Element\Tag $tag): void
    {
        \Pimcore\Model\Element\Tag::removeTagFromElement($cType, $cId, $tag);
    }

    /**
     * @param \Pimcore\Model\Element\Tag[] $tags
     */
    public function setTagsForElement(string $cType, int $cId, array $tags): void
    {
        \Pimcore\Model\Element\Tag::setTagsForElement($cType, $cId, $tags);
    }

    /**
     * @param int[] $cIds
     * @param int[] $tagIds
     */
    public function batchAssignTagsToElementIds(string $cType, array $cIds, array $tagIds, bool $replace = false): void
    {
        \Pimcore\Model\Element\Tag::batchAssignTagsToElement($cType, $cIds, $tagIds, $replace);
    }

    /**
     * @param iterable<AbstractElement> $objects
     * @param iterable<int>             $tagIds
     */
    public function batchAssignTagsToElements(iterable $objects, iterable $tagIds, bool $replace = false): void
    {
        foreach ($this->filter($objects) as $object) {
            $this->batchAssignTagsToElementIds($object->getType(), [$object->getId()], iterator_to_array($tagIds), $replace); // @phpstan-ignore-line
        }
    }

    /**
     * @param string[]       $subtypes
     * @param class-string[] $classNames
     *
     * @return AbstractElement[]
     */
    public function getElementsForTag(
        \Pimcore\Model\Element\Tag $tag,
        string $type,
        array $subtypes = [],
        array $classNames = [],
        bool $considerChildTags = false,
    ): array {
        return \Pimcore\Model\Element\Tag::getElementsForTag($tag, $type, $subtypes, $classNames, $considerChildTags);
    }

    /**
     * @param iterable<AbstractElement> $objects
     *
     * @return iterable<AbstractElement>
     */
    private function filter(iterable $objects): iterable
    {
        foreach ($objects as $object) {
            if ($object->getId() && \in_array($object->getType(), [self::CTYPE_ASSET, self::CTYPE_DOCUMENT, self::CTYPE_DATAOBJECT], true)) {
                yield $object;
            }
        }
    }
}
