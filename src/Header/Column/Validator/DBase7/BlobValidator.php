<?php declare(strict_types=1);

namespace TotalCRM\DBase\Header\Column\Validator\DBase7;

use TotalCRM\DBase\Enum\FieldType;
use TotalCRM\DBase\Header\Column\Validator\DBase\MemoValidator;

class BlobValidator extends MemoValidator
{
    public function getType(): array
    {
        return [
            FieldType::DBASE4_BLOB,
            FieldType::GENERAL,
        ];
    }
}
