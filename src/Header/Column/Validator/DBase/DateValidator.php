<?php declare(strict_types=1);

namespace TotalCRM\DBase\Header\Column\Validator\DBase;

use TotalCRM\DBase\Enum\FieldType;
use TotalCRM\DBase\Header\Column;
use TotalCRM\DBase\Header\Column\Validator\ColumnValidatorInterface;

class DateValidator implements ColumnValidatorInterface
{
    const LENGTH = 8;

    public function getType(): string
    {
        return FieldType::DATE;
    }

    public function validate(Column $column): void
    {
        $column->length = self::LENGTH;
    }
}
