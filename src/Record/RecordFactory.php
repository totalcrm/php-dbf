<?php declare(strict_types=1);

namespace TotalCRM\DBase\Record;

use TotalCRM\DBase\DataConverter\Encoder\EncoderInterface;
use TotalCRM\DBase\DataConverter\Record\DBase4DataConverter;
use TotalCRM\DBase\DataConverter\Record\DBase7DataConverter;
use TotalCRM\DBase\DataConverter\Record\DBaseDataConverter;
use TotalCRM\DBase\DataConverter\Record\FoxproDataConverter;
use TotalCRM\DBase\DataConverter\Record\RecordDataConverterInterface;
use TotalCRM\DBase\DataConverter\Record\VisualFoxproDataConverter;
use TotalCRM\DBase\Enum\TableType;
use TotalCRM\DBase\Table\Table;

class RecordFactory
{
    public static function create(
        Table $table,
        EncoderInterface $encoder,
        int $recordIndex,
        ?string $rawData = null
    ): ?RecordInterface {
        $class = self::getClass($table->getVersion());
        $refClass = new \ReflectionClass($class);
        if (!$refClass->implementsInterface(RecordInterface::class)) {
            return null;
        }

        return $refClass->newInstance(
            $table,
            $recordIndex,
            self::createDataConverter($table, $encoder)->fromBinaryString($rawData ?? '')
        );
    }

    public static function getClass(int $version): string
    {
        switch ($version) {
//            case TableType::DBASE_IV_MEMO:
//                return DBase4Record::class;

            case TableType::DBASE_7_NOMEMO:
            case TableType::DBASE_7_MEMO:
                return DBase7Record::class;

            case TableType::FOXPRO_MEMO:
                return FoxproRecord::class;

            case TableType::VISUAL_FOXPRO:
            case TableType::VISUAL_FOXPRO_AI:
            case TableType::VISUAL_FOXPRO_VAR:
                return VisualFoxproRecord::class;

            case TableType::DBASE_III_PLUS_MEMO:
            case TableType::DBASE_III_PLUS_NOMEMO:
            default:
                return DBaseRecord::class;
        }
    }

    /**
     * @return RecordDataConverterInterface
     */
    public static function createDataConverter(Table $table, EncoderInterface $encoder): RecordDataConverterInterface
    {
        switch ($table->getVersion()) {
            case TableType::DBASE_IV_MEMO:
                return new DBase4DataConverter($table, $encoder);

            case TableType::DBASE_7_NOMEMO:
            case TableType::DBASE_7_MEMO:
                return new DBase7DataConverter($table, $encoder);

            case TableType::FOXPRO_MEMO:
                return new FoxproDataConverter($table, $encoder);

            case TableType::VISUAL_FOXPRO:
            case TableType::VISUAL_FOXPRO_AI:
            case TableType::VISUAL_FOXPRO_VAR:
                return new VisualFoxproDataConverter($table, $encoder);

            case TableType::DBASE_III_PLUS_MEMO:
            case TableType::DBASE_III_PLUS_NOMEMO:
            default:
                return new DBaseDataConverter($table, $encoder);
        }
    }
}
