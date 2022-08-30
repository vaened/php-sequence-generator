<?php
/**
 * Created by enea dhack.
 */

declare(strict_types=1);

namespace Vaened\SequenceGenerator;

use Vaened\SequenceGenerator\Contracts\SequenceValue;

final class Sequence implements SequenceValue
{
    public function __construct(
        private readonly string $source,
        private readonly string $name,
        private int             $value,
    ) {
    }

    public function next(): int
    {
        return ++$this->value;
    }

    public function prev(): int
    {
        return --$this->value;
    }

    public function current(): int
    {
        return $this->value;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getQualifiedName(): string
    {
        return $this->name;
    }
}
