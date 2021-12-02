<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Field\Foxpro;

use TotalCRM\DBase\DataConverter\Field\AbstractFieldDataConverter;
use TotalCRM\DBase\Enum\FieldType;

class GeneralConverter extends AbstractFieldDataConverter
{
    public static function getType(): string
    {
        return FieldType::GENERAL;
    }

    public function fromBinaryString(string $value): ?int
    {
        if (empty($pointer = ltrim($value, ' '))) {
            return null;
        }

        return (int) $pointer;
    }

    public function toBinaryString($value): string
    {
        return str_pad((string) $value, $this->column->length, ' ', STR_PAD_LEFT);
    }
}
