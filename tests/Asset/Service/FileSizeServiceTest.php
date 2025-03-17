<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Asset\Service;

use Neusta\Pimcore\ToolboxBundle\Asset\Service\FileSizeService;
use PHPUnit\Framework\TestCase;
use Pimcore\Model\Asset;
use Prophecy\PhpUnit\ProphecyTrait;

class FileSizeServiceTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     *
     * @dataProvider sampleValues
     */
    public function determineFileSize(
        int $size,
        int $expectedSISize,
        int $expectedIECSize,
        string $expectedUnit,
        string $expectedShortForm,
        string $expectedIECUnit,
        string $expectedIECShortForm,
    ): void {
        $fileSizeService = new FileSizeService();

        $asset = $this->prophesize(Asset::class);
        $asset->getFileSize()->willReturn((int) $size);

        $fileSize = $fileSizeService->determineFileSize($asset->reveal());

        self::assertEquals($expectedSISize, $fileSize->size);
        self::assertEquals($expectedUnit, $fileSize->unit);
        self::assertEquals($expectedShortForm, $fileSize->shortUnit);
        self::assertEquals($expectedIECSize, $fileSize->iecSize);
        self::assertEquals($expectedIECUnit, $fileSize->iecUnit);
        self::assertEquals($expectedIECShortForm, $fileSize->iecShortUnit);
    }

    public function sampleValues()
    {
        yield '1 Byte' => [1, 1, 1, 'Byte', 'B', 'Byte', 'B'];
        yield '2 Bytes' => [2, 2, 2, 'Bytes', 'B', 'Bytes', 'B'];

        // power of 1000
        yield '1000 Bytes' => [1000, 1, 1000, 'Kilobyte', 'kB', 'Bytes', 'B'];
        yield '2000 Bytes' => [2000, 2, 1, 'Kilobytes', 'kB', 'KibiByte', 'kiB'];
        yield '1000000 Bytes' => [1000 * 1000, 1, 976, 'Megabyte', 'MB', 'KibiBytes', 'kiB'];
        yield '2000000 Bytes' => [2 * 1000 * 1000, 2, 1, 'Megabytes', 'MB', 'MebiByte', 'MiB'];
        yield '1000000000 Bytes' => [1000 * 1000 * 1000, 1, 953, 'Gigabyte', 'GB', 'MebiBytes', 'MiB'];
        yield '2000000000 Bytes' => [2 * 1000 * 1000 * 1000, 2, 1, 'Gigabytes', 'GB', 'GibiByte', 'GiB'];
        yield '10^12 Bytes' => [1000 * 1000 * 1000 * 1000, 1, 931, 'Terabyte', 'TB', 'GibiBytes', 'GiB'];
        yield '2*10^12 Bytes' => [2 * 1000 * 1000 * 1000 * 1000, 2, 1, 'Terabytes', 'TB', 'TebiByte', 'TiB'];
        yield '10^15 Bytes' => [1000 * 1000 * 1000 * 1000 * 1000, 1, 909, 'Petabyte', 'PB', 'TebiBytes', 'TiB'];
        yield '2*10^15 Bytes' => [2 * 1000 * 1000 * 1000 * 1000 * 1000, 2, 1, 'Petabytes', 'PB', 'PebiByte', 'PiB'];
        yield '10^18 Bytes' => [1000 * 1000 * 1000 * 1000 * 1000 * 1000, 1, 888, 'Exabyte', 'EB', 'PebiBytes', 'PiB'];
        yield '2*10^18 Bytes' => [2 * 1000 * 1000 * 1000 * 1000 * 1000 * 1000, 2, 1, 'Exabytes', 'EB', 'ExbiByte', 'EiB'];

        // power of 1024
        yield '1024 Bytes' => [1024, 1, 1, 'Kilobyte', 'kB', 'KibiByte', 'kiB'];
        yield '2048 Bytes' => [2 * 1024, 2, 2, 'Kilobytes', 'kB', 'KibiBytes', 'kiB'];
        yield '1048576 Bytes' => [1024 * 1024, 1, 1, 'Megabyte', 'MB', 'MebiByte', 'MiB'];
        yield 'viele Bytes' => [1024 * 1024 * 1024 * 1024, 1, 1, 'Terabyte', 'TB', 'TebiByte', 'TiB'];
        yield '2097152 Bytes' => [2 * 1024 * 1024, 2, 2, 'Megabytes', 'MB', 'MebiBytes', 'MiB'];
        yield '1073741824 Bytes' => [1024 * 1024 * 1024, 1, 1, 'Gigabyte', 'GB', 'GibiByte', 'GiB'];
        yield '2147483648 Bytes' => [2 * 1024 * 1024 * 1024, 2, 2, 'Gigabytes', 'GB', 'GibiBytes', 'GiB'];
        yield '1024^4 Bytes' => [1024 * 1024 * 1024 * 1024, 1, 1, 'Terabyte', 'TB', 'TebiByte', 'TiB'];
        yield '2*1024^4 Bytes' => [2 * 1024 * 1024 * 1024 * 1024, 2, 2, 'Terabytes', 'TB', 'TebiBytes', 'TiB'];
        yield '1024^5 Bytes' => [1024 * 1024 * 1024 * 1024 * 1024, 1, 1, 'Petabyte', 'PB', 'PebiByte', 'PiB'];
        yield '2*1024^5 Bytes' => [2 * 1024 * 1024 * 1024 * 1024 * 1024, 2, 2, 'Petabytes', 'PB', 'PebiBytes', 'PiB'];
        yield '1024^6 Bytes' => [1024 * 1024 * 1024 * 1024 * 1024 * 1024, 1, 1, 'Exabyte', 'EB', 'ExbiByte', 'EiB'];
        yield '2*1024^6 Bytes' => [2 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024, 2, 2, 'Exabytes', 'EB', 'ExbiBytes', 'EiB'];
    }
}
