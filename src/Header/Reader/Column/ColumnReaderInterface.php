<?php declare(strict_types=1);

namespace TotalCRM\DBase\Header\Reader\Column;

use TotalCRM\DBase\Header\Column;
use TotalCRM\DBase\Stream\StreamWrapper;

interface ColumnReaderInterface
{
    public function read(StreamWrapper $fp): Column;
}
