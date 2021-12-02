<?php declare(strict_types=1);

namespace TotalCRM\DBase\Memo\Creator;

interface MemoCreatorInterface
{
    public static function getExtension(): string;

    public function createFile(): string;
}
