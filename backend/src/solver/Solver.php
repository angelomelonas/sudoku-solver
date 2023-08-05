<?php

namespace App\solver;

use App\puzzle\code\Puzzle;
use App\strategy\Strategy;
use App\strategy\StrategyOneChoiceOnly;
use App\strategy\StrategySinglePossibility;

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
    const SOLVER_STRATEGY_INDEX_FIRST = 0;
    const SOLVER_STRATEGY_RESET_FIRST = 0;

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
    private $strategy_index_count;

    /**
     * @var int
     */
    private $strategy_reset_count;

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
            // TODO: Add more strategies here.
        ];
        $this->strategy_index_count = self::SOLVER_STRATEGY_INDEX_FIRST;
        $this->strategy_reset_count = self::SOLVER_STRATEGY_RESET_FIRST;
    }

    /**
     * @return Puzzle
     */
    public function solvePuzzle(): Puzzle
    {
        $strategy = $this->all_strategy[$this->strategy_index_count++];

        for ($index = 0; $index < self::SOLVER_ITERATIONS_MAX; $index++) {
            // Apply a single strategy until it stops changing the puzzle.
            $currentPuzzle = $this->applyStrategy($strategy, $this->puzzle);
            if ($this->isPuzzleUnchanged($this->puzzle, $currentPuzzle)) {
                if ($currentPuzzle->determineSolved()) {
                    return $currentPuzzle;
                } else {
                    $strategy = $this->getNextStrategy();
                }
            } else {
                $this->resetStrategyResetCount();
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
        if (isset($this->all_strategy[$this->strategy_index_count])) {
            return $this->all_strategy[$this->strategy_index_count++];
        } else {
            if ($this->strategy_reset_count == 0) {
                return $this->getFirstStrategy();
            } else {
                // TODO: return Bruteforce strategy.
                exit();
            }
        }
    }

    /**
     * @return Strategy
     */
    private function getFirstStrategy(): Strategy
    {
        $this->resetStrategyIndexCount();
        $this->incrementStrategyResetCount();

        return $this->all_strategy[$this->strategy_index_count];
    }

    /**
     */
    private function incrementStrategyResetCount()
    {
        $this->strategy_reset_count++;
    }

    /**
     */
    private function resetStrategyResetCount()
    {
        $this->strategy_reset_count = self::SOLVER_STRATEGY_RESET_FIRST;
    }

    /**
     */
    private function resetStrategyIndexCount()
    {
        $this->strategy_index_count = self::SOLVER_STRATEGY_INDEX_FIRST;
    }

    /**
     * @param Strategy $strategy
     * @param Puzzle $puzzle
     *
     * @return Puzzle
     */
    public function applyStrategy(
        Strategy $strategy,
        Puzzle $puzzle
    ): Puzzle {
        return $strategy->applyStrategy($puzzle);
    }

    /**
     * @param Puzzle $puzzle
     * @param Puzzle $currentPuzzle
     *
     * @return bool
     */
    private function isPuzzleUnchanged(
        Puzzle $puzzle,
        Puzzle $currentPuzzle
    ): bool {
        return $puzzle->getPuzzleArray() === $currentPuzzle->getPuzzleArray();
    }
}
