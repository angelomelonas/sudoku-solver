<?php

namespace sudoku\solver\strategy;

use sudoku\solver\puzzle\code\Puzzle;

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
        $rowDifference = array_diff($this->puzzle->getAllGroupNumber(), $row);
        $columnDifference = array_diff($this->puzzle->getAllGroupNumber(), $column);
        $regionDifference = array_diff($this->puzzle->getAllGroupNumber(), $region);

        $intersect = array_intersect($rowDifference, $columnDifference, $regionDifference);

        if (count($intersect) === 1) {
            $this->puzzle->setSquareValue($rowIndex, $columnIndex, reset($intersect));
        }
    }
}
