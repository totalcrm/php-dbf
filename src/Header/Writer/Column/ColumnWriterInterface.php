<?php declare(strict_types=1);

namespace TotalCRM\DBase\Header\Writer\Column;

use TotalCRM\DBase\Header\Column;
use TotalCRM\DBase\Stream\StreamWrapper;

interface ColumnWriterInterface
{
    public function write(StreamWrapper $fp, Column $column): void;
}
