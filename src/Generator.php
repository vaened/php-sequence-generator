<?php
/**
 * Created by enea dhack.
 */

declare(strict_types=1);

namespace Vaened\SequenceGenerator;

use Vaened\SequenceGenerator\Contracts\SequenceRepository;
use Vaened\SequenceGenerator\Contracts\SequenceValue;
use Vaened\SequenceGenerator\Stylists\Stylizer;
use function Lambdish\Phunctional\flatten;
use function Lambdish\Phunctional\map;

/**
 * Class Generator
 *
 * @package Vaened\SequenceGenerator
 * @author enea dhack <enea.so@live.com>
 *
 *
 */
class Generator
{
    public function __construct(
        private readonly Normalizer $normalizer,
    ) {
    }

    public function generate(string $source, array $seriesCollection): array
    {
        $collections = $this->normalizer->normalize($seriesCollection);
        $values = map($this->updateSequencesFor($source), $collections);

        return flatten($values);
    }

    private function updateSequencesFor(string $source): callable
    {
        return function (Collection $collection) use ($source) {
            return map($this->incrementTo($source, $collection->getRepository()), $collection->getSeries());
        };
    }

    private function incrementTo(string $source, SequenceRepository $repository): callable
    {
        return function (Serie $serie) use ($repository, $source): Generated {
            $sequence = $this->incrementByOne($source, $repository, $serie);
            $stylized = $this->applyStyles($sequence, $serie->getStylists());

            return new Generated($source, $stylized, $sequence->current(), $serie);
        };
    }

    private function incrementByOne(string $source, SequenceRepository $repository, Serie $serie): SequenceValue
    {
        return $repository->incrementByOne($source, $serie);
    }

    private function applyStyles(SequenceValue $sequence, array $stylists): string
    {
        return (new Stylizer($stylists))->stylize((string) $sequence->current());
    }
}
