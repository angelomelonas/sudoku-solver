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
        for ($row = 0; $row < $this->puzzle->getLength(); $row++) {
            for ($column = 0; $column < $this->puzzle->getLength(); $column++) {
                if ($this->puzzle->getSquareValue($row, $column) === self::UNSOLVED_SQUARE_VALUE) {
                    $this->solveGroup($this->puzzle->getRow($row), $row, $column);
                }
                if ($this->puzzle->getSquareValue($row, $column) === self::UNSOLVED_SQUARE_VALUE) {
                    $this->solveGroup($this->puzzle->getColumn($column), $row, $column);
                }
                if ($this->puzzle->getSquareValue($row, $column) === self::UNSOLVED_SQUARE_VALUE) {
                    $this->solveGroup($this->puzzle->getRegion($row, $column), $row, $column);
                }
            }
        }

        return $this->puzzle;
    }

    /**
     * @param array $group
     * @param int $row
     * @param int $column
     */
    private function solveGroup(array $group, int $row, int $column)
    {
        // Count the number of empty cells in the group.
        $counts = array_count_values($group);

        // Check if the group is eligible for the strategy, e.g., there is only 1 zero.
        if (isset($counts[0]) && $counts[0] === 1) {
            // Find the missing number.
            $solution = array_diff($this->puzzle->getAllGroupNumber(), $group);
            $this->puzzle->setSquareValue($row, $column, reset($solution));
        } else {
            // The group is not eligble for the strategy.
        }
    }
}
