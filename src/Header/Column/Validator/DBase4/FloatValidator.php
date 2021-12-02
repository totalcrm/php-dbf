<?php declare(strict_types=1);

namespace TotalCRM\DBase\Header\Column\Validator\DBase4;

use TotalCRM\DBase\Enum\FieldType;
use TotalCRM\DBase\Header\Column\Validator\DBase\NumberValidator;

class FloatValidator extends NumberValidator
{
    public function getType(): string
    {
        return FieldType::FLOAT;
    }
}
