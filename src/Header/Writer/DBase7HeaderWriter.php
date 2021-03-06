<?php declare(strict_types=1);

namespace TotalCRM\DBase\Header\Writer;

use TotalCRM\DBase\Enum\TableType;
use TotalCRM\DBase\Header\Header;

class DBase7HeaderWriter extends AbstractHeaderWriter
{
    protected function writeFirstBlock(Header $header): void
    {
        parent::writeFirstBlock($header);

        if (in_array($header->version, [TableType::DBASE_7_MEMO, TableType::DBASE_7_NOMEMO])) {
            $this->fp->write(str_pad($header->languageName ?? '', 36, chr(0)));
        }
    }
}
