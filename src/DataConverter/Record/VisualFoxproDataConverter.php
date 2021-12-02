<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Record;

use TotalCRM\DBase\DataConverter\Field\VisualFoxpro\BlobConverter;
use TotalCRM\DBase\DataConverter\Field\VisualFoxpro\CurrencyConverter;
use TotalCRM\DBase\DataConverter\Field\VisualFoxpro\DateTimeConverter;
use TotalCRM\DBase\DataConverter\Field\VisualFoxpro\DoubleConverter;
use TotalCRM\DBase\DataConverter\Field\VisualFoxpro\GeneralConverter;
use TotalCRM\DBase\DataConverter\Field\VisualFoxpro\IgnoreConverter;
use TotalCRM\DBase\DataConverter\Field\VisualFoxpro\IntegerConverter;
use TotalCRM\DBase\DataConverter\Field\VisualFoxpro\MemoConverter;
use TotalCRM\DBase\DataConverter\Field\VisualFoxpro\VarBinaryConverter;
use TotalCRM\DBase\DataConverter\Field\VisualFoxpro\VarFieldConverter;

class VisualFoxproDataConverter extends FoxproDataConverter
{
    protected static function getFieldConverters(): array
    {
        return array_merge([
            BlobConverter::class,
            CurrencyConverter::class,
            DateTimeConverter::class,
            DoubleConverter::class,
            GeneralConverter::class,
            IgnoreConverter::class,
            IntegerConverter::class,
            MemoConverter::class,
            VarFieldConverter::class,
            VarBinaryConverter::class,
        ], parent::getFieldConverters());
    }
}
