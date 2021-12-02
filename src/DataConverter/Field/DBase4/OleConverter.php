<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Field\DBase4;

class OleConverter extends BlobConverter
{
    /**
     * @return string
     */
    public static function getType(): string
    {
        return 'G';
    }
}
