<?php
namespace sudoku\solver\common\object;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200201 Initial creation.
 */
class Puzzle
{
    /**
     * @var int[][]
     */
    private $puzzle;

    /**
     * Puzzle constructor.
     *
     * @param int[][] $puzzle
     */
    public function __construct(array $puzzle)
    {
        $this->puzzle = $puzzle;
    }

    /**
     * @param int $row
     * @param int $column
     * @param int $newValue
     */
    public function updateCellValue(int $row, int $column, int $newValue)
    {
        $this->puzzle[$row][$column] = $newValue;
    }

    /**
     * @param int $row
     * @param int $column
     *
     * @return int
     */
    public function getCellValue(int $row, int $column): int
    {
        return $this->puzzle[$row][$column];
    }

    /**
     * @return int[][]
     */
    public function getPuzzleArrayInt(): array
    {
        return $this->puzzle;
    }

    /**
     * @param int[][] $puzzle
     */
    public function setPuzzleFromArrayInt(array $puzzle): void
    {
        $this->puzzle = $puzzle;
    }

    /**
     * @param array $puzzle
     *
     * @return string
     */
    public function toString(array $puzzle): string
    {
        // TODO: Improve
        echo "\n";
        foreach ($puzzle as $row) {
            foreach ($row as $cell) {
                echo $cell . " ";
            }
            echo "\n";
        }
    }
}
