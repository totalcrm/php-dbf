<?php declare(strict_types=1);

namespace TotalCRM\DBase\Header\Column\Validator\DBase7;

use TotalCRM\DBase\Enum\FieldType;
use TotalCRM\DBase\Header\Column;
use TotalCRM\DBase\Header\Column\Validator\ColumnValidatorInterface;

class IntegerValidator implements ColumnValidatorInterface
{
    const LENGTH = 4;

    public function getType(): array
    {
        return [
            FieldType::AUTO_INCREMENT,
            FieldType::INTEGER,
        ];
    }

    public function validate(Column $column): void
    {
        $column->length = self::LENGTH;
    }
}
