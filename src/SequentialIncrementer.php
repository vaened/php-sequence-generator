<?php
/**
 * Created by enea dhack.
 */

declare(strict_types=1);

namespace Vaened\SequenceGenerator;

final class SequentialIncrementer
{
    public function __construct(
        private readonly Normalizer $normalizer,
        private readonly Generator  $generator,
    ) {
    }

    public function resolve(string $source, array $presumedSeriesCollection): array
    {
        $collections = $this->normalizer->normalize($presumedSeriesCollection);
        return $this->generator->generate($source, $collections);
    }
}
