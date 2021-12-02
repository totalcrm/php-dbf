<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Field\VisualFoxpro;

use TotalCRM\DBase\DataConverter\Field\AbstractFieldDataConverter;
use TotalCRM\DBase\Enum\FieldType;

class GeneralConverter extends AbstractFieldDataConverter
{
    public static function getType(): string
    {
        return FieldType::GENERAL;
    }

    public function fromBinaryString(string $value): int
    {
        $data = unpack('L', $value);

        return $data[1];
    }

    /**
     * @param int|null $value
     */
    public function toBinaryString($value): string
    {
        return pack('L', $value);
    }
}
