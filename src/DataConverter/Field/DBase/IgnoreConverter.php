<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Field\DBase;

use TotalCRM\DBase\DataConverter\Field\AbstractFieldDataConverter;
use TotalCRM\DBase\Enum\FieldType;

/**
 * Class IgnoreConverter
 * @package TotalCRM\DBase\DataConverter\Field\DBase
 */
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
        return $value ?? str_pad('', $this->column->length);
    }
}
