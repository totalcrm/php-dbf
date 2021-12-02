<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Field\VisualFoxpro;

use TotalCRM\DBase\DataConverter\Field\AbstractFieldDataConverter;
use TotalCRM\DBase\Enum\FieldType;

class IgnoreConverter extends AbstractFieldDataConverter
{
    public static function getType(): string
    {
        return FieldType::IGNORE;
    }

    public function fromBinaryString(string $value): string
    {
        return $value;
    }

    public function toBinaryString($value): string
    {
        return $value ?? chr(0x20).chr(0x0a);
    }
}
