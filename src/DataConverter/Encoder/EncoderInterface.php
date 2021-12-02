<?php declare(strict_types=1);

namespace TotalCRM\DBase\DataConverter\Encoder;

/**
 * Interface EncoderInterface
 * @package TotalCRM\DBase\DataConverter\Encoder
 */
interface EncoderInterface
{
    public function encode(string $string, string $fromEncoding, string $toEncoding): string;
}
