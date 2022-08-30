<?php
/**
 * Created by enea dhack.
 */

declare(strict_types=1);

namespace Vaened\SequenceGenerator\Contracts;

use Vaened\SequenceGenerator\Serie;

interface SequenceRepository
{
    /**
     * Get all the sequences belonging to the same source.
     *
     * @param string $source
     * @return SequenceValue[]
     */
    public function getAllFrom(string $source): array;

    /**
     * Get the current sequence stored in the configured sequence table.
     *
     * @param string $source
     * @param Serie $serie
     * @return SequenceValue
     */
    public function getCurrentValue(string $source, Serie $serie): SequenceValue;

    /**
     * Increment the value of the sequence by 1 and return its instance.
     *
     * @param string $source
     * @param Serie $serie
     * @return SequenceValue
     */
    public function incrementByOne(string $source, Serie $serie): SequenceValue;

    /**
     * Increment the value of the sequence by N and return its instance.
     *
     * @param string $source
     * @param Serie $serie
     * @param int $quantity
     * @return SequenceValue
     */
    public function setValue(string $source, Serie $serie, int $quantity): SequenceValue;
}