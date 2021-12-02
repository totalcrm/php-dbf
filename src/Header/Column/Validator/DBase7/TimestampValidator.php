<?php declare(strict_types=1);

namespace TotalCRM\DBase\Header\Column\Validator\DBase7;

use TotalCRM\DBase\Enum\FieldType;
use TotalCRM\DBase\Header\Column\Validator\DBase\DateValidator;

class TimestampValidator extends DateValidator
{
    public function getType(): string
    {
        return FieldType::TIMESTAMP;
    }
}
