<?php
namespace sudoku\solver\puzzle\lib;

use sudoku\solver\puzzle\code\Puzzle;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200205 Initial creation.
 */
class PuzzleLib
{
    /**
     * @param Puzzle $puzzle
     * @param int $rowIndex
     *
     * @return int[]
     */
    public static function getRow(Puzzle $puzzle, int $rowIndex): array
    {
        return $puzzle->getPuzzleArray()[$rowIndex];
    }

    /**
     * @param Puzzle $puzzle
     * @param int $columnIndex
     *
     * @return array
     */
    public static function getColumn(Puzzle $puzzle, int $columnIndex): array
    {
        return array_column($puzzle->getPuzzleArray(), $columnIndex);
    }

    /**
     * @param Puzzle $puzzle
     * @param int $rowIndex
     * @param int $columnIndex
     *
     * @return int[][]
     */
    public static function getRegion(Puzzle $puzzle, int $rowIndex, int $columnIndex): array
    {
        $row = $rowIndex - $rowIndex % sqrt($puzzle->getLength());
        $column = $columnIndex - $columnIndex % sqrt($puzzle->getLength());

        $region = [];

        for ($rowIndex = $row; $rowIndex < $row + sqrt($puzzle->getLength()); $rowIndex++) {
            for ($columnIndex = $column; $columnIndex < $column + sqrt($puzzle->getLength()); $columnIndex++) {
                array_push($region, $puzzle->getPuzzleArray()[$rowIndex][$columnIndex]);
            }
        }

        return $region;
    }

    /**
     * @param Puzzle $puzzle
     *
     * @return bool
     */
    public static function determineSolved(Puzzle $puzzle)
    {
        $sum = 0;

        foreach ($puzzle as $row) {
            $sum += array_sum($row);
        }

        return $sum === $puzzle->getSolutionValue();
    }

    /**
     * @param Puzzle $puzzle
     *
     * @return bool
     */
    public static function determineValid(Puzzle $puzzle): bool
    {
        for ($rowIndex = 0; $rowIndex < $puzzle->getLength(); $rowIndex++) {
            for ($columnIndex = 0; $columnIndex < $puzzle->getLength(); $columnIndex++) {
                if (static::determineGroupValid(static::getRow($puzzle, $rowIndex))
                    && static::determineGroupValid(static::getColumn($puzzle, $columnIndex))
                    && static::determineGroupValid(static::getRegion($puzzle, $rowIndex, $columnIndex))) {
                    // All groups valid.
                } else {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param $group []
     *
     * @return bool
     */
    public static function determineGroupValid(array $group): bool
    {
        $counts = array_count_values($group);

        for ($index = 1; $index < count($group); $index++) {
            if (isset($counts[$index])) {
                if ($counts[$index] !== 1) {
                    return false;
                }
            }
        }

        return true;
    }
}
