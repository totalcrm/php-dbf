<?php declare(strict_types=1);

namespace TotalCRM\DBase\Table;

use TotalCRM\DBase\Header\Header;
use TotalCRM\DBase\Memo\MemoInterface;
use TotalCRM\DBase\Stream\Stream;

trait TableAwareTrait
{
    /**
     * @var Table
     */
    protected $table;

    protected function getHeader(): Header
    {
        return $this->table->header;
    }

    protected function getMemo(): ?MemoInterface
    {
        return $this->table->memo;
    }

    protected function getStream(): Stream
    {
        return $this->table->stream;
    }
}
