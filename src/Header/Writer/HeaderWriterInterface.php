<?php declare(strict_types=1);

namespace TotalCRM\DBase\Header\Writer;

use TotalCRM\DBase\Header\Header;

interface HeaderWriterInterface
{
    public function write(Header $header): void;
}
