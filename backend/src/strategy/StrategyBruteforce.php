<?php

namespace App\strategy;

use App\common\object\PossibilitySet;
use App\puzzle\code\Puzzle;
use App\puzzle\lib\PuzzleLib;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200208 Initial creation.
 */
class StrategyBruteforce extends Strategy
{
    /**
     * @param Puzzle $puzzle
     *
     * @return Puzzle
     */
    public function applyStrategy(Puzzle $puzzle): Puzzle
    {
        $this->puzzle = $puzzle;
        $allPossibility = [];
        for ($rowIndex = 0; $rowIndex < $this->puzzle->getLength(); $rowIndex++) {
            for ($columnIndex = 0; $columnIndex < $this->puzzle->getLength(); $columnIndex++) {
                if ($this->puzzle->getSquareValue($rowIndex, $columnIndex) === self::UNSOLVED_SQUARE_VALUE) {
                    $row = $this->puzzle->getRow($rowIndex);
                    $column = $this->puzzle->getColumn($columnIndex);
                    $region = $this->puzzle->getRegion($rowIndex, $columnIndex);

                    $rowDifference = array_diff($this->puzzle->getAllGroupNumber(), $row);
                    $columnDifference = array_diff($this->puzzle->getAllGroupNumber(), $column);
                    $regionDifference = array_diff($this->puzzle->getAllGroupNumber(), $region);

                    $possibilitySet =
                        new PossibilitySet(
                            $rowIndex,
                            $columnIndex,
                            $rowDifference + $columnDifference + $regionDifference
                        );

                    $allPossibility[] = [$rowIndex . $columnIndex, $possibilitySet];
                }
            }
        }

        usort(
            $allPossibility,
            function ($a, $b) {
                if ($a[1] instanceof PossibilitySet && $b[1] instanceof PossibilitySet) {
                    return $a[1]->getNumberOfPossibility() <=> $b[1]->getNumberOfPossibility();
                } else {
                    return false;
                }
            }
        );

        // TODO: Solve all easy squares with only one solution.
        if (isset($allPossibility[0][1])) {
            $possibilitySetFirst = $allPossibility[0][1];

            if ($possibilitySetFirst instanceof PossibilitySet) {
                return $this->solveRecursively($puzzle, $possibilitySetFirst, $allPossibility);
            } else {
                return $puzzle;
            }
        } else {
            return $puzzle;
        }
    }

    /**
     * @param Puzzle $puzzle
     * @param PossibilitySet $possibilitySet
     *
     * @param array $allPossibility
     * @param int $number
     *
     * @return mixed
     */
    private function solveRecursively(
        Puzzle $puzzle,
        PossibilitySet $possibilitySet,
        array $allPossibility,
        int $number
    ): Puzzle {
        // Deep copy.
        $currentPuzzle = $puzzle;

        // Current square
        $rowIndex = $possibilitySet->getRowIndex();
        $columnIndex = $possibilitySet->getColumnIndex();
        $currentAllPossibility = $possibilitySet->getAllPossibility();

        // Get next possibilities by removing the top one. // TODO: Move down
        $nextAllPossibility = array_shift($allPossibility)[1];

        foreach ($currentAllPossibility as $possibility) {
            if (isset($nextAllPossibility)) {
                if (PuzzleLib::determineCanSetValue($currentPuzzle, $rowIndex, $columnIndex, $possibility)) {
                    $currentPuzzle->setSquareValue($rowIndex, $columnIndex, $possibility);

                    return $this->solveRecursively(
                        $currentPuzzle,
                        $nextAllPossibility,
                        $allPossibility,
                        $number++
                    );
                } else {
                    // Solution not possible. Prune branch.
                    $currentPuzzle->setSquareValue($rowIndex, $columnIndex, 0);
                }
            } else {
                // Should be only one possibility left?
                $this->setSingleValue($currentPuzzle, $rowIndex, $columnIndex);
            }
        }

        return $currentPuzzle;
    }

    /**
     * @param Puzzle $currentPuzzle
     * @param int $rowIndex
     * @param int $columnIndex
     */
    private function setSingleValue(Puzzle $currentPuzzle, int $rowIndex, int $columnIndex)
    {
        // Should be only one possibility left?
        $row = $currentPuzzle->getRow($rowIndex);
        $column = $currentPuzzle->getColumn($columnIndex);
        $region = $currentPuzzle->getRegion($rowIndex, $columnIndex);

        $rowDifference = array_diff($currentPuzzle->getAllGroupNumber(), $row);
        $columnDifference = array_diff($currentPuzzle->getAllGroupNumber(), $column);
        $regionDifference = array_diff($currentPuzzle->getAllGroupNumber(), $region);

        $intersect = array_intersect($rowDifference, $columnDifference, $regionDifference);

        if (count($intersect) === 1) {
            $currentPuzzle->setSquareValue($rowIndex, $columnIndex, reset($intersect));
        } else {
            // Do nothing.
        }
    }
}
