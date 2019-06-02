<?php

declare(strict_types=1);

namespace AngeloMelonas\SudokuSolver\Strategies;

class OneChoiceOnly implements Strategy
{

    private $M;
    private $allPossibleGroupNumbers;
    private $currentPuzzle;

    /**
     * OneChoiceOnly constructor.
     * @param int $M
     */
    public function __construct(int $M)
    {
        $this->M = $M;
        // Generate all possible numbers in a group.
        $this->allPossibleGroupNumbers = range(1, $M);
        ;
    }

    public function applyStrategy(array $puzzle): array
    {
        $this->currentPuzzle = $puzzle;

        for ($i = 0; $i < $this->M; $i++) {
            for ($j = 0; $j < $this->M; $j++) {
                // For each cell, look in each row, column and region for a single answer.
                if ($this->currentPuzzle[$i][$j] == 0) {
                    $this->scanRow($this->currentPuzzle[$i], $i, $j);
                }
            }
        }

        return $this->currentPuzzle;
    }

    private function scanRow(array $row, int $i, int $j)
    {
        // Count the number of empty cells in the row.
        $counts = array_count_values($row);

        // Check if the row is eligible for the strategy.
        if ($counts[0] == 1) {
            // Find the missing number.
            $solution = array_diff($this->allPossibleGroupNumbers, $row);
            // Apply the solution.
            $this->currentPuzzle[$i][$j] = reset($solution);
        }
    }
}
