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

    private ?string $scope = null;

    private array $stylists = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function for(string $column): static
    {
        return new static($column);
    }

    public function scope(string ...$scopes): static
    {
        $this->scope = implode($this->getScopesSplitterCharacter(), $scopes);
        return $this;
    }

    public function styles(array $stylists): static
    {
        $this->stylists = $stylists;
        return $this;
    }

    public function hasScope(): bool
    {
        return $this->scope !== null;
    }

    public function getSerieName(): string
    {
        return $this->name;
    }

    public function getSerieScope(): ?string
    {
        return $this->scope;
    }

    public function getStylists(): array
    {
        return $this->stylists;
    }

    protected function getScopesSplitterCharacter(): string
    {
        return '-';
    }

    final public function getQualifiedName(): string
    {
        if (! $this->hasScope()) {
            return $this->getSerieName();
        }

        return "{$this->getSerieName()}.{$this->getSerieScope()}";
    }
}
