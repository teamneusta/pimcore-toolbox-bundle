<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\DataObject;

use Neusta\Pimcore\ToolboxBundle\DataObject\Publishing;
use PHPUnit\Framework\TestCase;
use Pimcore\Model\DataObject;

class PublishingTest extends TestCase
{
    /**
     * @test
     */
    public function withUnpublishedObjects_executes_the_callable_with_unpublished_objects(): void
    {
        DataObject::setHideUnpublished(true);

        self::assertTrue(DataObject::doHideUnpublished());
        self::assertFalse(Publishing::withUnpublishedObjects(static fn () => DataObject::doHideUnpublished()));
        self::assertTrue(DataObject::doHideUnpublished());
    }

    /**
     * @test
     */
    public function withUnpublishedObjects_passes_trailing_args_to_the_callable(): void
    {
        $args = [0, 'foo', true, null, [123, 456 => 'bar'], new \stdClass()];

        self::assertSame($args, Publishing::withUnpublishedObjects(static fn (...$a): array => $a, ...$args));
    }

    /**
     * @test
     */
    public function withoutUnpublishedObjects_executes_the_callable_without_unpublished_objects(): void
    {
        DataObject::setHideUnpublished(false);

        self::assertFalse(DataObject::doHideUnpublished());
        self::assertTrue(Publishing::withoutUnpublishedObjects(static fn () => DataObject::doHideUnpublished()));
        self::assertFalse(DataObject::doHideUnpublished());
    }

    /**
     * @test
     */
    public function withoutUnpublishedObjects_passes_trailing_args_to_the_callable(): void
    {
        $args = [0, 'foo', true, null, [123, 456 => 'bar'], new \stdClass()];

        self::assertSame($args, Publishing::withoutUnpublishedObjects(static fn (...$a): array => $a, ...$args));
    }
}
