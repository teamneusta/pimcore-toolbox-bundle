<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Asset\Service;

use Neusta\Pimcore\ToolboxBundle\Asset\Model\FileSize;
use Pimcore\Model\Asset;

class FileSizeService
{
    /**
     * @var list<array{string, string, string, string, string, string}>
     */
    public const UNITS = [
        ['Byte', 'Bytes', 'B', 'Byte', 'Bytes', 'B'],
        ['Kilobyte', 'Kilobytes', 'kB', 'KibiByte', 'KibiBytes', 'kiB'],
        ['Megabyte', 'Megabytes', 'MB', 'MebiByte', 'MebiBytes', 'MiB'],
        ['Gigabyte', 'Gigabytes', 'GB', 'GibiByte', 'GibiBytes', 'GiB'],
        ['Terabyte', 'Terabytes', 'TB', 'TebiByte', 'TebiBytes', 'TiB'],
        ['Petabyte', 'Petabytes', 'PB', 'PebiByte', 'PebiBytes', 'PiB'],
        ['Exabyte', 'Exabytes', 'EB', 'ExbiByte', 'ExbiBytes', 'EiB'],
        // Sollte int jemals größer werden, wären das die nächsten Einheiten ;-)
        // ['Zettabyte', 'Zettabytes', 'ZB'],
        // ['Yottabyte', 'Yottabytes', 'YB'],
    ];
    public const CONVERSION_FACTOR_IEC = 1024;
    public const CONVERSION_FACTOR_SI = 1000;

    public function determineFileSize(Asset $file): FileSize
    {
        $fileSizeBytes = (int) $file->getFileSize();

        list($powerSI, $roundedValueSI) = $this->calculateExchangeValue($fileSizeBytes, self::CONVERSION_FACTOR_SI);
        list($powerIEC, $roundedValueIEC) = $this->calculateExchangeValue($fileSizeBytes, self::CONVERSION_FACTOR_IEC);

        return new FileSize(
            $roundedValueSI,
            1 === $roundedValueSI ? self::UNITS[$powerSI][0] : self::UNITS[$powerSI][1],
            self::UNITS[$powerSI][2],
            $roundedValueIEC,
            1 === $roundedValueIEC ? self::UNITS[$powerIEC][3] : self::UNITS[$powerIEC][4],
            self::UNITS[$powerIEC][5],
        );
    }

    /**
     * @return int[]
     */
    private function calculateExchangeValue(int $fileSizeBytes, int $conversionFactor): array
    {
        $power = 0;
        $maximum = $conversionFactor;
        while ($fileSizeBytes >= $maximum) {
            $maximum *= $conversionFactor;
            ++$power;
        }
        $maximum /= $conversionFactor;
        $roundedValue = (int) round((int) ($fileSizeBytes / $maximum), 2);

        return [$power, $roundedValue];
    }
}
