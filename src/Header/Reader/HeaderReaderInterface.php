<?php declare(strict_types=1);

namespace TotalCRM\DBase\Header\Reader;

use TotalCRM\DBase\Header\Header;

interface HeaderReaderInterface
{
    /**
     * Reads data from file and build instance of Header.
     */
    public function read(): Header;
}
