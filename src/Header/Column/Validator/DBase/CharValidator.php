<?php declare(strict_types=1);

namespace TotalCRM\DBase\Header\Column\Validator\DBase;

use TotalCRM\DBase\Enum\FieldType;
use TotalCRM\DBase\Exception\ColumnException;
use TotalCRM\DBase\Header\Column;
use TotalCRM\DBase\Header\Column\Validator\ColumnValidatorInterface;

class CharValidator implements ColumnValidatorInterface
{
    const MAX_LENGTH = 254;

    public function getType(): string
    {
        return FieldType::CHAR;
    }

    public function validate(Column $column): void
    {
        if (empty($column->length) || $column->length < 1 || $column->length > self::MAX_LENGTH) {
            throw new ColumnException(sprintf('Char column length must be in range [1, %s]', self::MAX_LENGTH));
        }
    }
}
