<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Document;

use Neusta\Pimcore\ToolboxBundle\Document\Publishing;
use PHPUnit\Framework\TestCase;
use Pimcore\Model\Document;

class PublishingTest extends TestCase
{
    /**
     * @test
     */
    public function withUnpublishedDocuments_executes_the_callable_with_unpublished_documents(): void
    {
        Document::setHideUnpublished(true);

        self::assertTrue(Document::doHideUnpublished());
        self::assertFalse(Publishing::withUnpublishedDocuments(static fn () => Document::doHideUnpublished()));
        self::assertTrue(Document::doHideUnpublished());
    }

    /**
     * @test
     */
    public function withUnpublishedDocuments_passes_trailing_args_to_the_callable(): void
    {
        $args = [0, 'foo', true, null, [123, 456 => 'bar'], new \stdClass()];

        self::assertSame($args, Publishing::withUnpublishedDocuments(static fn (...$a): array => $a, ...$args));
    }

    /**
     * @test
     */
    public function withoutUnpublishedDocuments_executes_the_callable_without_unpublished_documents(): void
    {
        Document::setHideUnpublished(false);

        self::assertFalse(Document::doHideUnpublished());
        self::assertTrue(Publishing::withoutUnpublishedDocuments(static fn () => Document::doHideUnpublished()));
        self::assertFalse(Document::doHideUnpublished());
    }

    /**
     * @test
     */
    public function withoutUnpublishedDocuments_passes_trailing_args_to_the_callable(): void
    {
        $args = [0, 'foo', true, null, [123, 456 => 'bar'], new \stdClass()];

        self::assertSame($args, Publishing::withoutUnpublishedDocuments(static fn (...$a): array => $a, ...$args));
    }
}
