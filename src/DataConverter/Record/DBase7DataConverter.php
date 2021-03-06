<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Record;

use TotalCRM\DBase\DataConverter\Field\DBase7\AiConverter;
use TotalCRM\DBase\DataConverter\Field\DBase7\DoubleConverter;
use TotalCRM\DBase\DataConverter\Field\DBase7\IntegerConverter;
use TotalCRM\DBase\DataConverter\Field\DBase7\MemoConverter;
use TotalCRM\DBase\DataConverter\Field\DBase7\TimestampConverter;

class DBase7DataConverter extends DBase4DataConverter
{
    protected static function getFieldConverters(): array
    {
        return array_merge([
            AiConverter::class,
            DoubleConverter::class,
            IntegerConverter::class,
            TimestampConverter::class,
            MemoConverter::class,
        ], parent::getFieldConverters());
    }
}
