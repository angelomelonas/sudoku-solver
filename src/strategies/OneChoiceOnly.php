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
    }

    public function applyStrategy(array $puzzle): array
    {
        $this->currentPuzzle = $puzzle;

        for ($i = 0; $i < $this->M; $i++) {
            for ($j = 0; $j < $this->M; $j++) {
                // For each cell, look in each row, column and region for a single answer.
                $this->scanRow($this->currentPuzzle[$i], $i, $j);
                $this->scanColumn(array_column($this->currentPuzzle, $j), $i, $j);
                $this->scanRegion($this->getRegion($this->currentPuzzle, $i, $j), $i, $j);
            }
        }

        return $this->currentPuzzle;
    }

    private function scanRow(array $row, int $i, int $j)
    {
        if ($this->currentPuzzle[$i][$j] === 0) {
            $this->solveGroup($row, $i, $j);
        }
    }

    private function scanColumn(array $column, int $i, int $j)
    {
        if ($this->currentPuzzle[$i][$j] === 0) {
            $this->solveGroup($column, $i, $j);
        }
    }

    private function scanRegion(array $region, int $i, int $j)
    {
        if ($this->currentPuzzle[$i][$j] === 0) {
            $this->solveGroup($region, $i, $j);
        }
    }

    private function solveGroup(array $group, int $i, int $j)
    {
        // Count the number of empty cells in the group.
        $counts = array_count_values($group);

        // Check if the group is eligible for the strategy, e.g., there is only 1 zero.
        if ($counts[0] == 1) {
            // Find the missing number.
            $solution = array_diff($this->allPossibleGroupNumbers, $group);
            $this->currentPuzzle[$i][$j] = reset($solution);
        }
    }

    private function getRegion(array $puzzle, $i, $j): array
    {
        // Calculate the region bounds.
        $r = $i - $i % sqrt($this->M);
        $c = $j - $j % sqrt($this->M);

        $region = array();

        for ($i = $r; $i < $r + sqrt($this->M); $i++) {
            for ($j = $c; $j < $c + sqrt($this->M); $j++) {
                array_push($region, $puzzle[$i][$j]);
            }
        }

        return $region;
    }
}
