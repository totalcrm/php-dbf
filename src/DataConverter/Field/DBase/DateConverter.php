<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Field\DBase;

use TotalCRM\DBase\DataConverter\Field\AbstractFieldDataConverter;
use TotalCRM\DBase\Enum\FieldType;

/**
 * Class DateConverter
 * @package TotalCRM\DBase\DataConverter\Field\DBase
 */
class DateConverter extends AbstractFieldDataConverter
{
    public static function getType(): string
    {
        return FieldType::DATE;
    }

    public function fromBinaryString(string $value): ?string
    {
        return $value;
    }

    public function toBinaryString($value): string
    {
        return null === $value ? str_pad('', $this->column->length) : $value;
    }
}
