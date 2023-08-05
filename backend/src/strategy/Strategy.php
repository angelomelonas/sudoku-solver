<?php

namespace App\strategy;

use App\puzzle\code\Puzzle;

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
     */
    public function __construct()
    {
        $this->puzzle = [];
    }

    /**
     * @param Puzzle $puzzle
     *
     * @return Puzzle
     */
    abstract public function applyStrategy(Puzzle $puzzle);
}
