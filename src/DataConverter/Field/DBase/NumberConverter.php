<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Field\DBase;

use TotalCRM\DBase\DataConverter\Field\AbstractFieldDataConverter;
use TotalCRM\DBase\Enum\FieldType;

/**
 * Class NumberConverter
 * @package TotalCRM\DBase\DataConverter\Field\DBase
 */
class NumberConverter extends AbstractFieldDataConverter
{
    public static function getType(): string
    {
        return FieldType::NUMERIC;
    }

    public function fromBinaryString(string $value)
    {
        $s = trim($value);
        if ('' === $s) {
            return null;
        }

        $s = str_replace(',', '.', $s);

        if ($this->column->decimalCount > 0 || $this->column->length > 9) {
            return (float) $s;
        }

        return (int) $s;
    }

    public function toBinaryString($value): string
    {
        if (null === $value) {
            return str_repeat(chr(0x00), $this->column->length);
        }

        return str_pad(
            number_format($value, $this->column->decimalCount, '.', ''),
            $this->column->length,
            ' ',
            STR_PAD_LEFT
        );
    }
}
