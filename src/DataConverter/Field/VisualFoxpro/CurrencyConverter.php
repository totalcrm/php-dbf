<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Field\VisualFoxpro;

use TotalCRM\DBase\DataConverter\Field\AbstractFieldDataConverter;
use TotalCRM\DBase\Enum\FieldType;

class CurrencyConverter extends AbstractFieldDataConverter
{
    public static function getType(): string
    {
        return FieldType::CURRENCY;
    }

    public function fromBinaryString(string $value): float
    {
        $value = unpack('q', $value);

        if ($value) {
            return $value[1] / 10000;
        }

        return 0.0;
    }

    public function toBinaryString($value): string
    {
        if (null === $value) {
            return str_pad('', $this->column->length, chr(0x00));
        }

        return pack('q', (int) ($value * 10000));
    }
}
