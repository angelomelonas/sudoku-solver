<?php

namespace sudoku\solver\strategy;

use sudoku\solver\puzzle\code\Puzzle;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200201 Initial creation.
 */
class StrategyOnlySquare extends Strategy
{

    /**
     * @param Puzzle $puzzle
     *
     * @return Puzzle
     */
    public function applyStrategy(Puzzle $puzzle): Puzzle
    {
        $this->puzzle = $puzzle;

        for ($rowIndex = 0; $rowIndex < $this->puzzle->getLength(); $rowIndex++) {
            for ($columnIndex = 0; $columnIndex < $this->puzzle->getLength(); $columnIndex++) {
                if ($this->puzzle->getSquareValue($rowIndex, $columnIndex) === self::UNSOLVED_SQUARE_VALUE) {
                    $row = $this->puzzle->getRow($rowIndex);
                    $column = $this->puzzle->getColumn($columnIndex);
                    $region = $this->puzzle->getRegion($rowIndex, $columnIndex);
                    $this->solve($row, $column, $region, $rowIndex, $columnIndex);
                }
            }
        }

        return $this->puzzle;
    }

    /**
     * @param array $row
     * @param array $column
     * @param array $region
     * @param int $rowIndex
     * @param int $columnIndex
     */
    private function solve(array $row, array $column, array $region, int $rowIndex, int $columnIndex)
    {
        // TODO: Implement.
    }
}
