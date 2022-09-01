<?php
/**
 * Created by enea dhack.
 */

declare(strict_types=1);

namespace Vaened\SequenceGenerator;

class Generated
{
    private readonly string $serieName;

    private readonly string $qualifiedName;

    public function __construct(
        private readonly string $source,
        private readonly string $stylizedSequence,
        private readonly int    $cleanSequence,
        Serie                   $serie
    ) {
        $this->serieName     = $serie->getSerieName();
        $this->qualifiedName = $serie->getQualifiedName();
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getSerieName(): string
    {
        return $this->serieName;
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
