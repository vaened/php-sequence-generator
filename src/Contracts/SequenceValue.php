<?php
/**
 * Created by enea dhack.
 */

declare(strict_types=1);

namespace Vaened\SequenceGenerator\Contracts;

interface SequenceValue
{
    /**
     * Superficially increases by one.
     *
     * @return int
     */
    public function next(): int;

    /**
     * Superficially decreases by one.
     *
     * @return int
     */
    public function prev(): int;

    /**
     * Returns the current sequence in use.
     *
     * @return int
     * */
    public function current(): int;

    /**
     * The source name that will contain a collection of sequences.
     *
     * @return string
     * */
    public function getSource(): string;

    /**
     * The individual name of the sequence within the collection.
     *
     * @return string
     * */
    public function getQualifiedName(): string;
}