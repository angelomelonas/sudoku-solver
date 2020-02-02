<?php

namespace sudoku\solver\strategy;

use sudoku\solver\common\object\Puzzle;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200202 Initial creation.
 */
class StrategySinglePossibility extends Strategy
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
        // TODO: Implement.
    }
}
