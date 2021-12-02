<?php declare(strict_types=1);

namespace TotalCRM\DBase\Header\Column\Validator\DBase;

use TotalCRM\DBase\Enum\FieldType;
use TotalCRM\DBase\Header\Column;
use TotalCRM\DBase\Header\Column\Validator\ColumnValidatorInterface;

class MemoValidator implements ColumnValidatorInterface
{
    const LENGTH = 10;

    public function getType(): array
    {
        return [
            FieldType::MEMO,
        ];
    }

    public function validate(Column $column): void
    {
        $column->length = self::LENGTH;
    }
}
