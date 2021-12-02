<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Field\DBase7;

use TotalCRM\DBase\Enum\FieldType;

/**
 * Class AiConverter
 * @package TotalCRM\DBase\DataConverter\Field\DBase7
 */
class AiConverter extends IntegerConverter
{
    /**
     * @return string
     */
    public static function getType(): string
    {
        return FieldType::AUTO_INCREMENT;
    }
}
