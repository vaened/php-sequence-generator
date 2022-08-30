<?php
/**
 * Created by enea dhack.
 */

declare(strict_types=1);

namespace Vaened\SequenceGenerator\Contracts;

interface Stylist
{
    public function stylize(string $generated): string;
}
