<?php
/**
 * Created by enea dhack.
 */

declare(strict_types=1);

namespace Vaened\SequenceGenerator;

use Vaened\SequenceGenerator\Contracts\SequenceRepository;
use Vaened\SequenceGenerator\Contracts\SequenceValue;
use Vaened\SequenceGenerator\Stylists\Stylizer;
use function Lambdish\Phunctional\flat_map;
use function Lambdish\Phunctional\map;

/**
 * Class Generator
 *
 * Generates the sequences and stores them in the database using the repository of each collection.
 *
 * @package Vaened\SequenceGenerator
 * @author enea dhack <enea.so@live.com>
 */
class Generator
{
    public function generate(string $source, array $seriesCollections): array
    {
        return flat_map($this->updateSequencesFor($source), $seriesCollections);
    }

    private function updateSequencesFor(string $source): callable
    {
        return fn(Collection $collection) => map(
            $this->incrementTo($source, $collection->getRepository()),
            $collection->getSeries()
        );
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
