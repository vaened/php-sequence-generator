<?php
/**
 * Created by enea dhack.
 */

declare(strict_types=1);

namespace Vaened\SequenceGenerator;

class Generated
{
    private readonly string $simpleName;

    private readonly string $qualifiedName;

    public function __construct(
        private readonly string $source,
        private readonly string $stylizedSequence,
        private readonly int $cleanSequence,
        Serie                   $serie
    ) {
        $this->simpleName = $serie->getSerieName();
        $this->qualifiedName = $serie->getSerieID();
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getSimpleName(): string
    {
        return $this->simpleName;
    }

    public function getQualifiedName(): string
    {
        return $this->qualifiedName;
    }

    public function getStylizedSequence(): string
    {
        return $this->stylizedSequence;
    }

    public function getCleanSequence(): int
    {
        return $this->cleanSequence;
    }
}
