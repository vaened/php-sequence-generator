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
use function Lambdish\Phunctional\flat_map;
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
final class Normalizer
{
    private readonly SequenceRepository $repository;

    public function __construct(SequenceRepository $defaultRepository)
    {
        $this->repository = $defaultRepository;
    }

    public function normalize(array $presumedSeriesCollections): array
    {
        $collections = $this->collectOrphanSeries($presumedSeriesCollections);

        $this->validateDuplicates($collections);

        return $collections;
    }

    private function collectOrphanSeries(array $seriesCollections): array
    {
        $series = filter(static fn(Collection|Serie $instance) => $instance instanceof Serie, $seriesCollections);
        $collections = filter(static fn(Collection|Serie $instance) => $instance instanceof Collection, $seriesCollections);

        array_unshift($collections, $this->collect($series));

        return $collections;
    }

    private function validateDuplicates(array $collections): void
    {
        $duplicates = $this->getDuplicateNames($collections);
        some(static fn(string $name) => throw new SequenceError("the name '$name' is already registeredregistered"), $duplicates);
    }

    private function getDuplicateNames(array $collections): array
    {
        $serialIdentifiers = flat_map($this->toSeries(), $collections);

        return array_diff_assoc($serialIdentifiers, array_unique($serialIdentifiers));
    }

    private function toSeries(): callable
    {
        return fn(Collection $collection) => map($this->toSerieName(), $collection->getSeries());
    }

    private function toSerieName(): callable
    {
        return static fn(Serie $serial) => $serial->getSerieName();
    }

    private function collect(array $series): Collection
    {
        return new Collection($this->repository, $series);
    }
}
