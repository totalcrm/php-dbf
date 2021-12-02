<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Field;

use TotalCRM\DBase\DataConverter\Encoder\EncoderInterface;
use TotalCRM\DBase\Header\Column;
use TotalCRM\DBase\Table\Table;

abstract class AbstractFieldDataConverter implements FieldDataConverterInterface
{
    /** @var Table */
    protected $table;

    /** @var Column */
    protected $column;

    /** @var EncoderInterface */
    protected $encoder;

    public function __construct(Table $table, Column $column, EncoderInterface $encoder)
    {
        $this->table = $table;
        $this->column = $column;
        $this->encoder = $encoder;
    }
}
