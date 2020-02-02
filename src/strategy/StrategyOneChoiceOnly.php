<?php

namespace sudoku\solver\strategy;

use sudoku\solver\common\object\Puzzle;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200201 Initial creation.
 */
class StrategyOneChoiceOnly extends Strategy
{
    /**
     * @param Puzzle $puzzle
     */
    public function __construct(Puzzle $puzzle)
    {
        parent::__construct($puzzle);
    }

    /**
     * @return Puzzle
     */
    public function applyStrategy(): Puzzle
    {
        for ($rowIndex = 0; $rowIndex < $this->puzzle->getLength(); $rowIndex++) {
            for ($columnIndex = 0; $columnIndex < $this->puzzle->getLength(); $columnIndex++) {
                if ($this->puzzle->getSquareValue($rowIndex, $columnIndex) === self::UNSOLVED_SQUARE_VALUE) {
                    $this->solve($this->puzzle->getRow($rowIndex), $rowIndex, $columnIndex);
                }
                if ($this->puzzle->getSquareValue($rowIndex, $columnIndex) === self::UNSOLVED_SQUARE_VALUE) {
                    $this->solve($this->puzzle->getColumn($columnIndex), $rowIndex, $columnIndex);
                }
                if ($this->puzzle->getSquareValue($rowIndex, $columnIndex) === self::UNSOLVED_SQUARE_VALUE) {
                    $this->solve($this->puzzle->getRegion($rowIndex, $columnIndex), $rowIndex, $columnIndex);
                }
            }
        }

        return $this->puzzle;
    }

    /**
     * @param array $group
     * @param int $rowIndex
     * @param int $columnIndex
     */
    private function solve(array $group, int $rowIndex, int $columnIndex)
    {
        // Count the number of empty cells in the group.
        $counts = array_count_values($group);

        // Check if the group is eligible for the strategy, e.g., there is only 1 zero.
        if ($counts[0] === 1) {
            // Find the missing number.
            $solution = array_diff($this->puzzle->getAllGroupNumber(), $group);
            $this->puzzle->setSquareValue($rowIndex, $columnIndex, reset($solution));
        } else {
            // The group is not eligble for the strategy.
        }
    }
}
