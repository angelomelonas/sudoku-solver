<?php

declare(strict_types=1);

namespace AngeloMelonas\SudokuSolver;

use AngeloMelonas\SudokuSolver\Strategies\OneChoiceOnly;

class Solver {

    private $puzzle;
    private $M;
    private $solutionValue;

    public function __construct($puzzle) {
        $this->puzzle = $puzzle;
        $this->M = (int) sqrt(count($puzzle[0]));

        // Calculate the solution value of this puzzle (i.e., the sum of all values in the grid).
        $this->solutionValue = ((1 + $this->M) / 2) * $this->M;
    }

    public function solve() {
        $oneChoiceOnlyStrategy = new OneChoiceOnly($this->M);

        $puzzle = $this->puzzle;

        // TODO: This is an arbitrary number to avoid infinite looping.
        while (10000) {
            // Apply a single strategy until it stops changing the puzzle.
            $currentPuzzle = $this->applyStrategy($oneChoiceOnlyStrategy, $puzzle);
            echo "\nFokkkk\n";
            if (!$this->puzzleChanged($puzzle, $currentPuzzle)) {
                // Check if the puzzle has been solved.
                if ($this->isPuzzleSolved($currentPuzzle)) {
                    return $currentPuzzle;
                } else{
                    // TODO: Swap out the current strategy.
                }
            }
        }
    }

    public function applyStrategy(OneChoiceOnly $strategy, array $puzzle): array {
        return $strategy->applyStrategy($puzzle);
    }

    private function puzzleChanged(array $puzzle, array $currentPuzzle): bool {
        return $puzzle != $currentPuzzle;
    }

    private function isPuzzleSolved(array $puzzle) {
        $sum = 0;
        foreach ($puzzle as $row) {
            $sum += array_sum($row);
        }
        return $sum == $this->solutionValue;
    }
}
