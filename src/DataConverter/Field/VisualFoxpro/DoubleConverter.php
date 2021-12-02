<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Field\VisualFoxpro;

use TotalCRM\DBase\DataConverter\Field\AbstractFieldDataConverter;
use TotalCRM\DBase\Enum\FieldType;

class DoubleConverter extends AbstractFieldDataConverter
{
    public static function getType(): string
    {
        return FieldType::DOUBLE;
    }

    public function fromBinaryString(string $value): float
    {
        $value = unpack('d', $value);

        if ($value) {
            return (float) $value[1];
        }

        return 0.0;
    }

    /**
     * @param float|null $value
     */
    public function toBinaryString($value): string
    {
        if (null === $value) {
            return str_pad('', $this->column->length, chr(0x00));
        }

        return pack('d', $value);
    }
}
