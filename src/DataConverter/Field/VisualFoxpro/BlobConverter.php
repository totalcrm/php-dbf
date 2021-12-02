<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Field\VisualFoxpro;

use TotalCRM\DBase\Enum\FieldType;

class BlobConverter extends MemoConverter
{
    public static function getType(): string
    {
        return FieldType::BLOB;
    }
}
