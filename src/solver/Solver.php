<?php

namespace sudoku\solver\solver;

use sudoku\solver\puzzle\code\Puzzle;
use sudoku\solver\strategy\Strategy;
use sudoku\solver\strategy\StrategyOneChoiceOnly;
use sudoku\solver\strategy\StrategySinglePossibility;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200201 Initial creation.
 */
class Solver
{
    /**
     * Solver constants.
     */
    const SOLVER_ITERATIONS_MAX = 100;
    const SOLVER_PUZZLE_INDEX_FIRST = 0;

    /**
     * @var Puzzle
     */
    private $puzzle;

    /**
     * @var Strategy[]
     */
    private $all_strategy;

    /**
     * @var int
     */
    private $strategy_index;

    /**
     * Solver constructor.
     *
     * @param Puzzle $puzzle
     */
    public function __construct(Puzzle $puzzle)
    {
        $this->puzzle = $puzzle;
        $this->all_strategy = [
            new StrategyOneChoiceOnly(),
            new StrategySinglePossibility(),
            // Add strategies here.
        ];
        $this->strategy_index = self::SOLVER_PUZZLE_INDEX_FIRST;
    }

    /**
     * @return Puzzle
     */
    public function solvePuzzle(): Puzzle
    {
        $strategy = $this->all_strategy[$this->strategy_index++];

        for ($index = 0; $index < self::SOLVER_ITERATIONS_MAX; $index++) {
            // Apply a single strategy until it stops changing the puzzle.
            $currentPuzzle = $this->applyStrategy($strategy, $this->puzzle);
            if ($this->isPuzzleUnchanged($this->puzzle, $currentPuzzle)) {
                // Check if the puzzle has been solved.
                if ($currentPuzzle->determineSolved()) {
                    return $currentPuzzle;
                } else {
                    $strategy = $this->getNextStrategy();
                }
            }

            $this->puzzle = $currentPuzzle;
        }

        // Puzzle unsolved.
        return $this->puzzle;
    }

    /**
     * @return Strategy
     */
    private function getNextStrategy(): Strategy
    {
        if (isset($this->all_strategy[$this->strategy_index])) {
            return $this->all_strategy[$this->strategy_index++];
        } else {
            $this->resetStrategyIndex();

            return $this->all_strategy[$this->strategy_index];
        }
    }

    /**
     */
    private function resetStrategyIndex(): void
    {
        // TODO: Implement brute force strategy when all other strategies have been exhausted.
        $this->strategy_index = self::SOLVER_PUZZLE_INDEX_FIRST;
    }

    /**
     * @param Strategy $strategy
     * @param Puzzle $puzzle
     *
     * @return Puzzle
     */
    public function applyStrategy(Strategy $strategy, Puzzle $puzzle): Puzzle
    {
        return $strategy->applyStrategy($puzzle);
    }

    /**
     * @param Puzzle $puzzle
     * @param Puzzle $currentPuzzle
     *
     * @return bool
     */
    private function isPuzzleUnchanged(Puzzle $puzzle, Puzzle $currentPuzzle): bool
    {
        return $puzzle->getPuzzleArray() === $currentPuzzle->getPuzzleArray();
    }
}
