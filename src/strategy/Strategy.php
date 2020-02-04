<?php

namespace sudoku\solver\strategy;

use sudoku\solver\puzzle\code\Puzzle;

/**
 * Interface Strategy
 *
 * @package sudoku\solver\strategy
 */
abstract class Strategy
{
    /**
     * Strategy constants.
     */
    const UNSOLVED_SQUARE_VALUE = 0;

    /**
     * @var Puzzle
     */
    protected $puzzle;

    /**
     * Strategy constructor.
     *
     * @param Puzzle $puzzle
     */
    public function __construct(Puzzle $puzzle)
    {
        $this->puzzle = $puzzle;
    }

    /**
     * @return Puzzle
     */
    abstract public function applyStrategy();
}
