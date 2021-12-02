<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Field\DBase7;

use TotalCRM\DBase\DataConverter\Field\AbstractFieldDataConverter;
use TotalCRM\DBase\Enum\FieldType;

/**
 * Class DoubleConverter
 * @package TotalCRM\DBase\DataConverter\Field\DBase7
 */
class DoubleConverter extends AbstractFieldDataConverter
{
    /**
     * @return string
     */
    public static function getType(): string
    {
        return FieldType::DBASE7_DOUBLE;
    }

    /**
     * @param string $value
     * @return float
     */
    public function fromBinaryString(string $value): float
    {
        $buf = unpack('C*', $value);
        $buf = array_map(function ($v) {
            return str_pad(decbin($v), 8, '0', STR_PAD_LEFT);
        }, $buf);

        $negative = '0' === $buf[1][0];
        if ($negative) {
            $buf = array_map(function ($v) {
                return $this->inverseBits($v);
            }, $buf);
        }

        $result = unpack('E', pack('C*', ...array_map('bindec', $buf)));
        if ($result) {
            $result = (float) abs($result[1]);
            if ($negative) {
                $result = -($result);
            }

            return $result;
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

        return pack('E', $value);
    }

    /**
     * @param string $bin
     * @return string
     */
    private function inverseBits(string $bin): string
    {
        $len = strlen($bin);
        $result = '';
        for ($i = 0; $i < $len; $i++) {
            $result .= '0' === $bin[$i] ? '1' : '0';
        }

        return $result;
    }
}
