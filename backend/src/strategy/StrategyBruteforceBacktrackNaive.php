<?php
namespace App\strategy;

use App\puzzle\code\Puzzle;
use App\puzzle\lib\PuzzleLib;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200216 Initial creation.
 */
class StrategyBruteforceBacktrackNaive extends Strategy
{
    /**
     * @param Puzzle $puzzle
     *
     * @return Puzzle
     */
    public function applyStrategy(Puzzle $puzzle): Puzzle
    {
        $this->solveRecursively($puzzle, $puzzle->getLength());

        return $puzzle;
    }

    /**
     * @param Puzzle $puzzle
     * @param int $n
     *
     * @return mixed
     */
    private function solveRecursively(
        Puzzle $puzzle,
        int $n
    ): bool {
        $rowIndex = -1;
        $columnIndex = -1;
        $isEmpty = true;

        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                if ($puzzle->getSquareValue($i, $j) === 0) {
                    $rowIndex = $i;
                    $columnIndex = $j;
                    $isEmpty = false;
                    break;
                }
            }
            if (!$isEmpty) {
                break;
            }
        }

        if ($isEmpty) {
            return true;
        }

        for ($num = 1; $num <= $n; $num++) {
            if (PuzzleLib::determineCanSetValue($puzzle, $rowIndex, $columnIndex, $num)) {
                $puzzle->setSquareValue($rowIndex, $columnIndex, $num);

                if ($this->solveRecursively($puzzle, $n)) {
                    return true;
                } else {
                    $puzzle->setSquareValue($rowIndex, $columnIndex, 0);
                }
            }
        }

        return false;
    }
}
