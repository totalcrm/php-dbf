<?php declare(strict_types=1);

namespace TotalCRM\DBase\Header\Writer;

use TotalCRM\DBase\Enum\TableType;
use TotalCRM\DBase\Stream\StreamWrapper;

class HeaderWriterFactory
{
    public static function create(int $version, StreamWrapper $fp): HeaderWriterInterface
    {
        $fp->seek(0);

        switch ($version) {
            case TableType::DBASE_7_MEMO:
            case TableType::DBASE_7_NOMEMO:
                return new DBase7HeaderWriter($fp);

            case TableType::VISUAL_FOXPRO:
            case TableType::VISUAL_FOXPRO_AI:
            case TableType::VISUAL_FOXPRO_VAR:
                return new VisualFoxproHeaderWriter($fp);

            default:
                return new DBaseHeaderWriter($fp);
        }
    }
}
