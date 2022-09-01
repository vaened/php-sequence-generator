<?php
/**
 * Created by enea dhack.
 */

declare(strict_types=1);

namespace Vaened\SequenceGenerator;

use function implode;

class Serie
{
    private string $name;

    private ?string $alias = null;

    private array $stylists = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function for(string $column): static
    {
        return new static($column);
    }

    public function alias(string ...$aliases): static
    {
        $this->alias = implode($this->getAliasesSplitterCharacter(), $aliases);
        return $this;
    }

    public function styles(array $stylists): static
    {
        $this->stylists = $stylists;
        return $this;
    }

    public function hasAlias(): bool
    {
        return $this->alias !== null;
    }

    public function getSerieName(): string
    {
        return $this->name;
    }

    public function getSerieAlias(): ?string
    {
        return $this->alias;
    }

    public function getStylists(): array
    {
        return $this->stylists;
    }

    protected function getAliasesSplitterCharacter(): string
    {
        return '-';
    }

    final public function getQualifiedName(): string
    {
        if (! $this->hasAlias()) {
            return $this->getSerieName();
        }

        return "{$this->getSerieName()}.{$this->getSerieAlias()}";
    }
}
