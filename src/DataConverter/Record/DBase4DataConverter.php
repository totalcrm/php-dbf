<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Record;

use TotalCRM\DBase\DataConverter\Field\DBase4\BlobConverter;
use TotalCRM\DBase\DataConverter\Field\DBase4\FloatConverter;
use TotalCRM\DBase\DataConverter\Field\DBase4\OleConverter;

class DBase4DataConverter extends DBaseDataConverter
{
    protected static function getFieldConverters(): array
    {
        return array_merge([
            BlobConverter::class,
            FloatConverter::class,
            OleConverter::class,
        ], parent::getFieldConverters());
    }
}
