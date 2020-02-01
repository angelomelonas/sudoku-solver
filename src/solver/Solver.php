<?php

namespace sudoku\solver\solver;

use sudoku\solver\common\object\Puzzle;
use sudoku\solver\strategy\Strategy;
use sudoku\solver\strategy\StrategyOneChoiceOnly;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200201 Initial creation.
 */
class Solver
{
    /**
     * @var Puzzle
     */
    private $puzzle;

    /**
     * Solver constructor.
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
    public function solvePuzzle(): Puzzle
    {
        $count = 0;
        // TODO: This is an arbitrary number to avoid infinite looping.
        while ($count < 100) {
            // Apply a single strategy until it stops changing the puzzle.
            $currentPuzzle = $this->applyStrategy(new StrategyOneChoiceOnly($this->puzzle));

            if (!$this->hasSquareBeenSolved($this->puzzle, $currentPuzzle)) {
                // Check if the puzzle has been solved.
                if ($currentPuzzle->determineSolved()) {
                    return $currentPuzzle;
                } else {
                    // TODO: Swap out the current strategy.
                }
            }

            $this->puzzle = $currentPuzzle;

            $count++;
        }

        // Puzzle unsolved.
        return $this->puzzle;
    }

    /**
     * @param Strategy $strategy
     *
     * @return Puzzle
     */
    public function applyStrategy(Strategy $strategy): Puzzle
    {
        return $strategy->applyStrategy();
    }

    /**
     * @param Puzzle $puzzle
     * @param Puzzle $currentPuzzle
     *
     * @return bool
     */
    private function hasSquareBeenSolved(Puzzle $puzzle, Puzzle $currentPuzzle): bool
    {
        return $puzzle !== $currentPuzzle;
    }
}
