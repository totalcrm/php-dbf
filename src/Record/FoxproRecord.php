<?php declare(strict_types=1);

namespace TotalCRM\DBase\Record;

use TotalCRM\DBase\Enum\FieldType;
use TotalCRM\DBase\Header\Column;

class FoxproRecord extends AbstractRecord
{
    public function get(string $columnName)
    {
        $column = $this->table->getColumn($columnName);

        switch ($column->type) {
            case FieldType::GENERAL:
                return $this->getGeneral($column);
            default:
                return parent::get($columnName);
        }
    }

    protected function getGeneral(Column $column)
    {
        $this->checkType($column, FieldType::GENERAL);

        return $this->getMemoObject($column->name)->getData();
    }
}
