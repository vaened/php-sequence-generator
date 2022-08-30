<?php
/**
 * Created by enea dhack.
 */

declare(strict_types=1);

namespace Vaened\SequenceGenerator\Stylists;

use Vaened\SequenceGenerator\Contracts\Stylist;
use function Lambdish\Phunctional\each;

class Stylizer implements Stylist
{
    public function __construct(
        private readonly array $stylists
    ) {
    }

    public function stylize(string $generated): string
    {
        $value = $generated;

        each(function (Stylist $stylist) use (&$value) {
            $value = $stylist->stylize($value);
        }, $this->stylists);

        return $value;
    }
}
