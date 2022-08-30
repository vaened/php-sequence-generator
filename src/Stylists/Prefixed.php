<?php
/**
 * Created by enea dhack.
 */

declare(strict_types=1);

namespace Vaened\SequenceGenerator\Stylists;

use Vaened\SequenceGenerator\Contracts\Stylist;
use function preg_match;
use function strlen;
use function substr;

class Prefixed implements Stylist
{
    public function __construct(
        private readonly string $prefix,
        private readonly bool   $additional = false
    ) {
    }

    public function stylize(string $generated): string
    {
        if ($this->additional || !preg_match('/^0+/', $generated)) {
            return $this->apply($generated);
        }

        $formatted = substr($generated, strlen($this->prefix));

        return $this->apply($formatted);
    }

    private function apply(string $generated): string
    {
        return "$this->prefix$generated";
    }
}
