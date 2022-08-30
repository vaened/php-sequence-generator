<?php
/**
 * Created by enea dhack.
 */

declare(strict_types=1);

namespace Vaened\SequenceGenerator;

use Vaened\SequenceGenerator\Contracts\SequenceRepository;

class Collection
{
    public function __construct(
        private readonly SequenceRepository $repository,
        private array                       $series = []
    ) {
    }

    public function attach(array $series): static
    {
        $this->series = $series;
        return $this;
    }

    public function getSeries(): array
    {
        return $this->series;
    }

    public function getRepository(): SequenceRepository
    {
        return $this->repository;
    }
}
