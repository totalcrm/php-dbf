<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Field\DBase4;

use TotalCRM\DBase\DataConverter\Field\AbstractFieldDataConverter;
use TotalCRM\DBase\Enum\FieldType;

/**
 * Class FloatConverter
 * @package TotalCRM\DBase\DataConverter\Field\DBase4
 */
class FloatConverter extends AbstractFieldDataConverter
{
    /**
     * @return string
     */
    public static function getType(): string
    {
        return FieldType::FLOAT;
    }

    /**
     * @param string $value
     * @return float
     */
    public function fromBinaryString(string $value): float
    {
        return (float) ltrim($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function toBinaryString($value): string
    {
        return str_pad((string) ($value ?? ''), $this->column->length);
    }
}
