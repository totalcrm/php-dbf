<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Record;

use TotalCRM\DBase\Record\RecordInterface;

/**
 * Converts table row binary data to normal RecordInterface data and back.
 */
interface RecordDataConverterInterface
{
    public function fromBinaryString(string $rawData): array;

    public function toBinaryString(RecordInterface $record): string;
}
