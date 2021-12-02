<?php declare(strict_types=1);

namespace TotalCRM\DBase\Header\Writer;

use TotalCRM\DBase\Enum\TableType;
use TotalCRM\DBase\Header\Header;

class VisualFoxproHeaderWriter extends AbstractHeaderWriter
{
    protected function writeRest(Header $header): void
    {
        assert(in_array($header->version, [
            TableType::VISUAL_FOXPRO,
            TableType::VISUAL_FOXPRO_AI,
            TableType::VISUAL_FOXPRO_VAR,
        ]));

        parent::writeRest($header);

        $this->fp->write(str_pad($header->backlist, 263));
    }
}
