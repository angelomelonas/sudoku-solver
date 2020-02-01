<?php

namespace sudoku\solver\strategy;

/**
 * Interface Strategy
 *
 * @package sudoku\solver\strategy
 */
interface Strategy
{
    /**
     * @param array $puzzle
     *
     * @return array
     */
    public function applyStrategy(array $puzzle): array;
}
