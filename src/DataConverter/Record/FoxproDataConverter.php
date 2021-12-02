<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Record;

use TotalCRM\DBase\DataConverter\Field\Foxpro\FloatConverter;
use TotalCRM\DBase\DataConverter\Field\Foxpro\GeneralConverter;

class FoxproDataConverter extends DBaseDataConverter
{
    protected static function getFieldConverters(): array
    {
        return array_merge([
            FloatConverter::class,
            GeneralConverter::class,
        ], parent::getFieldConverters());
    }
}
