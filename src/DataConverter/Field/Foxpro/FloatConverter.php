<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Field\Foxpro;

use TotalCRM\DBase\DataConverter\Field\AbstractFieldDataConverter;
use TotalCRM\DBase\Enum\FieldType;

class FloatConverter extends AbstractFieldDataConverter
{
    public static function getType(): string
    {
        return FieldType::FLOAT;
    }

    public function fromBinaryString(string $value): float
    {
        return (float) ltrim($value);
    }

    public function toBinaryString($value): string
    {
        if (null !== $value) {
            $value = number_format($value, $this->column->decimalCount, '.', '');
        }

        return str_pad($value ?? '', $this->column->length, ' ', STR_PAD_LEFT);
    }
}
