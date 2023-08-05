<?php
namespace App\common\object;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200210 Initial creation.
 */
class PossibilitySet
{
    /**
     * @var int
     */
    private $rowIndex;
    /**
     * @var int
     */
    private $columnIndex;
    /**
     * @var int[]
     */
    private $allPossibility;

    /**
     * PossibilitySet constructor.
     *
     * @param int $rowIndex
     * @param int $columnIndex
     * @param array $allPossibility
     */
    public function __construct(int $rowIndex, int $columnIndex, array $allPossibility)
    {
        $this->rowIndex = $rowIndex;
        $this->columnIndex = $columnIndex;
        $this->allPossibility = $allPossibility;
    }

    /**
     * @return int
     */
    public function getRowIndex(): int
    {
        return $this->rowIndex;
    }

    /**
     * @return int
     */
    public function getColumnIndex(): int
    {
        return $this->columnIndex;
    }

    /**
     * @return int[]
     */
    public function getAllPossibility(): array
    {
        return $this->allPossibility;
    }

    /**
     * @return int
     */
    public function getNumberOfPossibility(): int
    {
        return count($this->allPossibility);
    }
}
