<?php declare(strict_types=1);

namespace TotalCRM\DBase\Memo\Creator;

use TotalCRM\DBase\Stream\Stream;

class DBase7MemoCreator extends AbstractMemoCreator
{
    protected function writeHeader(Stream $stream): void
    {
        $stream->write(pack('V', 1)); //next block
        $stream->write(str_pad('', 4, chr(0))); //reserved

        $stream->seek(20); //version number
        $stream->writeUShort(512); //blockLengthInBytes
    }
}
