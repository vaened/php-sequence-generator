<?php
/**
 * Created by enea dhack.
 */

declare(strict_types=1);

namespace Vaened\SequenceGenerator;

use Vaened\SequenceGenerator\Contracts\SequenceRepository;
use Vaened\SequenceGenerator\Exceptions\SequenceError;
use function array_diff_assoc;
use function array_unique;
use function array_unshift;
use function Lambdish\Phunctional\filter;
use function Lambdish\Phunctional\flatten;
use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\some;

/**
 * Class Normalizer
 *
 * Take a collection of series collections and transform the orphaned series into a default collection.
 *
 * @package Vaened\SequenceGenerator
 * @author enea dhack <enea.so@live.com>
 */
class Normalizer
{
    private SequenceRepository $repository;

    public function __construct(SequenceRepository $defaultRepository)
    {
        $this->repository = $defaultRepository;
    }

    public function normalize(array $seriesCollection): array
    {
        $collections = $this->collectOrphanSeries($seriesCollection);

        $this->validateDuplicates($collections);

        return $collections;
    }

    private function collectOrphanSeries(array $seriesCollection): array
    {
        $series = filter(static fn(Collection|Serie $instance) => $instance instanceof Serie, $seriesCollection);
        $collections = filter(static fn(Collection|Serie $instance) => $instance instanceof Collection, $seriesCollection);

        array_unshift($collections, $this->collect($series));

        return $collections;
    }

    private function validateDuplicates(array $collections): void
    {
        $duplicates = $this->getDuplicateIdentifiers($collections);
        some(static fn(string $identifier) => throw new SequenceError("the identifier '$identifier' is already registered"), $duplicates);
    }

    private function getDuplicateIdentifiers(array $collections): array
    {
        $serialIdentifiers = map($this->toSeries(), $collections);
        $flattenIdentifiers = flatten($serialIdentifiers);

        return array_diff_assoc($flattenIdentifiers, array_unique($flattenIdentifiers));
    }

    private function toSeries(): callable
    {
        return fn(Collection $collection) => map($this->toSerialID(), $collection->getSeries());
    }

    private function toSerialID(): callable
    {
        return static fn(Serie $serial) => $serial->getSerieID();
    }

    private function collect(array $series): Collection
    {
        return new Collection($this->repository, $series);
    }
}
