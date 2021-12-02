<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Field\DBase7;

use TotalCRM\DBase\DataConverter\Field\DBase\MemoConverter as DBaseMemoConverter;

/**
 * Class MemoConverter
 * @package TotalCRM\DBase\DataConverter\Field\DBase7
 */
class MemoConverter extends DBaseMemoConverter
{
    /**
     * @return string
     */
    protected function getFillerChar(): string
    {
        return '0';
    }
}
