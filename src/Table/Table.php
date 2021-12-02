<?php declare(strict_types=1);

namespace TotalCRM\DBase\Table;

use TotalCRM\DBase\Header\Column;
use TotalCRM\DBase\Header\Header;
use TotalCRM\DBase\Memo\MemoInterface;
use TotalCRM\DBase\Stream\Stream;

class Table
{
    /**
     * @var string
     */
    public $filepath;

    /**
     * @var array
     */
    public $options = [
        'encoding' => null,
        'editMode' => null,
    ];

    /**
     * @var Header
     */
    public $header;

    /**
     * @var Stream
     */
    public $stream;

    /**
     * @var MemoInterface|null
     */
    public $memo;

    /**
     * @var array
     */
    public $handlers = [];

    public function getVersion()
    {
        return $this->header->version;
    }

    public function getColumn(string $name): Column
    {
        foreach ($this->header->columns as $column) {
            if ($column->name === $name) {
                return $column;
            }
        }

        throw new \Exception("Column $name not found");
    }
}
