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
     * @var int
     */
    private $length;

    /**
     * @var int[]
     */
    private $allGroupNumber;

    /**
     * @var int
     */
    private $solutionValue;

    /**
     * Puzzle constructor.
     *
     * @param int[][] $puzzle
     */
    public function __construct(array $puzzle)
    {
        $this->puzzle = $puzzle;
        $this->length = count($puzzle[0]);
        $this->allGroupNumber = range(1, $this->length);
        $this->solutionValue = (((1 + $this->length) / 2) * $this->length) * $this->length;
    }

    /**
     * @param int $rowIndex
     *
     * @return int[]
     */
    public function getRow(int $rowIndex): array
    {
        return $this->puzzle[$rowIndex];
    }

    /**
     * @param int $columnIndex
     *
     * @return array
     */
    public function getColumn(int $columnIndex): array
    {
        return array_column($this->puzzle, $columnIndex);
    }

    /**
     * @param int $rowIndex
     * @param int $columnIndex
     *
     * @return int[][]
     */
    public function getRegion(int $rowIndex, int $columnIndex): array
    {
        $row = $rowIndex - $rowIndex % sqrt($this->length);
        $column = $columnIndex - $columnIndex % sqrt($this->length);

        $region = [];

        for ($rowIndex = $row; $rowIndex < $row + sqrt($this->length); $rowIndex++) {
            for ($columnIndex = $column; $columnIndex < $column + sqrt($this->length); $columnIndex++) {
                array_push($region, $this->puzzle[$rowIndex][$columnIndex]);
            }
        }

        return $region;
    }

    /**
     * @param int $rowIndex
     * @param int $columnIndex
     * @param int $newValue
     */
    public function setSquareValue(int $rowIndex, int $columnIndex, int $newValue)
    {
        $this->puzzle[$rowIndex][$columnIndex] = $newValue;
    }

    /**
     * @param int $rowIndex
     * @param int $columnIndex
     *
     * @return int
     */
    public function getSquareValue(int $rowIndex, int $columnIndex): int
    {
        return $this->puzzle[$rowIndex][$columnIndex];
    }

    /**
     * @return int[][]
     */
    public function getPuzzleArray(): array
    {
        return $this->puzzle;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @return int[]
     */
    public function getAllGroupNumber(): array
    {
        return $this->allGroupNumber;
    }

    /**
     * @return int
     */
    public function getSolutionValue(): int
    {
        return $this->solutionValue;
    }

    /**
     * @return bool
     */
    public function determineSolved()
    {
        $sum = 0;

        foreach ($this->puzzle as $row) {
            $sum += array_sum($row);
        }

        return $sum === $this->solutionValue;
    }

    /**
     * @param array $puzzle
     */
    public function toString(array $puzzle): void
    {
        // TODO: Improve this toString function.
        echo "\n";
        foreach ($puzzle as $row) {
            foreach ($row as $cell) {
                echo $cell . " ";
            }
            echo "\n";
        }
    }
}
