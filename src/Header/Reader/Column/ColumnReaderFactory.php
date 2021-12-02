<?php declare(strict_types=1);

namespace TotalCRM\DBase\Header\Reader\Column;

use TotalCRM\DBase\Enum\TableType;

class ColumnReaderFactory
{
    public static function create(int $version): ColumnReaderInterface
    {
        switch ($version) {
            case TableType::DBASE_7_MEMO:
            case TableType::DBASE_7_NOMEMO:
                return new DBase7ColumnReader();

            default:
                return new DBaseColumnReader();
        }
    }
}
