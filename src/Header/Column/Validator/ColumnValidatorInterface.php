<?php declare(strict_types=1);

namespace TotalCRM\DBase\Header\Column\Validator;

use TotalCRM\DBase\Header\Column;

interface ColumnValidatorInterface
{
    /**
     * @return string|array
     */
    public function getType();

    public function validate(Column $column): void;
}
