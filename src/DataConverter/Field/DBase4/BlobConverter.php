<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Field\DBase4;

use TotalCRM\DBase\DataConverter\Field\AbstractFieldDataConverter;
use TotalCRM\DBase\Enum\FieldType;

/**
 * Class BlobConverter
 * @package TotalCRM\DBase\DataConverter\Field\DBase4
 */
class BlobConverter extends AbstractFieldDataConverter
{
    /**
     * @return string
     */
    public static function getType(): string
    {
        return FieldType::DBASE4_BLOB; //blob
    }

    /**
     * @param string $value
     * @return int|null
     */
    public function fromBinaryString(string $value): ?int
    {
        if (empty($pointer = ltrim($value, ' 0'))) {
            return null;
        }

        return (int) $pointer;
    }

    /**
     * @param $value
     * @return string
     */
    public function toBinaryString($value): string
    {
        $value = null === $value ? '' : (string) $value;

        return str_pad($value, $this->column->length, '0', STR_PAD_LEFT);
    }
}
