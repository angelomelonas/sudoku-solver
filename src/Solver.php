<?php

declare(strict_types=1);

namespace AngeloMelonas\SudokuSolver;

use AngeloMelonas\SudokuSolver\Strategies\OneChoiceOnly;

class Solver
{

    private $puzzle;
    private $M;
    private $solutionValue;

    public function __construct($puzzle)
    {
        $this->puzzle = $puzzle;
        $this->M = count($puzzle[0]);

        // Calculate the solution value of this puzzle (i.e., the sum of all values in the grid).
        $this->solutionValue = (((1 + $this->M) / 2) * $this->M) * $this->M;
    }

    public function solve()
    {
        $oneChoiceOnlyStrategy = new OneChoiceOnly($this->M);

        $count = 0;
        // TODO: This is an arbitrary number to avoid infinite looping.
        while ($count < 100) {
            // Apply a single strategy until it stops changing the puzzle.
            $currentPuzzle = $this->applyStrategy($oneChoiceOnlyStrategy, $this->puzzle);

            if (!$this->puzzleChanged($this->puzzle, $currentPuzzle)) {
                // Check if the puzzle has been solved.
                if ($this->isPuzzleSolved($currentPuzzle)) {
                    echo "\nCompleted in " . $count . " iterations.";
                    return $currentPuzzle;
                } else {
                    // TODO: Swap out the current strategy.
                }
            }

            $this->puzzle = $currentPuzzle;

            $count++;
        }
        return $this->puzzle;
    }

    public function applyStrategy(OneChoiceOnly $strategy, array $puzzle): array
    {
        return $strategy->applyStrategy($puzzle);
    }

    private function puzzleChanged(array $puzzle, array $currentPuzzle): bool
    {
        // Returns true if the puzzle has changed.
        return $puzzle != $currentPuzzle;
    }

    private function isPuzzleSolved(array $puzzle)
    {
        $sum = 0;
        foreach ($puzzle as $row) {
            $sum += array_sum($row);
        }
        return $sum == $this->solutionValue;
    }
}
