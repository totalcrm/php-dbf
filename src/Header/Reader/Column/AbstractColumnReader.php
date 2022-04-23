<?php declare(strict_types=1);

namespace TotalCRM\DBase\Header\Reader\Column;

use TotalCRM\DBase\Header\Column;
use TotalCRM\DBase\Header\Specification\Specification;
use TotalCRM\DBase\Stream\StreamWrapper;

abstract class AbstractColumnReader implements ColumnReaderInterface
{
    /** @var Specification */
    private $spec;

    public function __construct()
    {
        $this->spec = $this->getSpecification();
    }

    abstract protected function getSpecification(): Specification;

    public function read(StreamWrapper $fp, ?int $index = null): Column
    {
        $memoryChunk = $fp->read($this->spec->fieldLength);
        if (($len = strlen($memoryChunk)) !== $this->spec->fieldLength) {
            throw new \LogicException('Column data expected length: '.$this->spec->fieldLength.' got: '.$len);
        }

        return $this->createColumn($memoryChunk, $index);
    }

    protected function createColumn(string $memoryChunk, ?int $index = null): Column
    {
        $properties = $this->extractArgs($memoryChunk);

        $column = new Column();
        foreach ($properties as $property => $value) {
            $column->{$property} = $value;
        }

        return $column;
    }

    abstract protected function extractArgs(string $memoryChunk): array;
}
