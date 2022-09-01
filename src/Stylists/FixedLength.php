<?php
/**
 * Created by enea dhack.
 */

declare(strict_types=1);

namespace Vaened\SequenceGenerator\Stylists;

use Vaened\SequenceGenerator\Contracts\Stylist;
use Vaened\SequenceGenerator\Exceptions\SequenceError;

class FixedLength implements Stylist
{
    public function __construct(
        private readonly int $length,
        private readonly int $padType = STR_PAD_LEFT
    ) {
    }

    public static function of(int $length, int $padType = STR_PAD_LEFT): static
    {
        return new static($length, $padType);
    }

    public function stylize(string $generated): string
    {
        $this->validateLength($generated);
        return $this->toFixedLength($generated);
    }

    private function toFixedLength(string $generated): string
    {
        return str_pad($generated, $this->length, '0', $this->padType);
    }

    private function validateLength(string $generated): void
    {
        if ($this->length > 0 && strlen($generated) > $this->length) {
            throw new SequenceError('the sequence has exceeded the size limit');
        }
    }
}
