<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Field\DBase7;

use TotalCRM\DBase\DataConverter\Field\AbstractFieldDataConverter;
use TotalCRM\DBase\Enum\FieldType;

/**
 * Class TimestampConverter
 * @package TotalCRM\DBase\DataConverter\Field\DBase7
 */
class TimestampConverter extends AbstractFieldDataConverter
{
    private const UTC_TO_JD = 0x42cc418ba99a00;
    private const SEC_TO_JD = 500;

    /**
     * @return string
     */
    public static function getType(): string
    {
        return FieldType::TIMESTAMP;
    }

    /**
     * @param string $value
     * @return int
     */
    public function fromBinaryString(string $value): int
    {
        $buf = unpack('H14', $value);

        return (int) ((hexdec($buf[1]) - self::UTC_TO_JD) / self::SEC_TO_JD);
    }

    /**
     * @param $value
     * @return string
     */
    public function toBinaryString($value): string
    {
        $hex = dechex($value * self::SEC_TO_JD + self::UTC_TO_JD);

        return pack('H16', $hex.'00');
    }
}
