<?php

namespace sudoku\solver\test;

use PHPUnit\Framework\TestCase;
use sudoku\solver\common\object\Puzzle;
use sudoku\solver\strategy\StrategyOneChoiceOnly;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200201 Initial creation.
 */
class StrategyOneChoiceOnlyTest extends TestCase
{
    /**
     */
    public function testSingleRow()
    {
        $strategyInput = [
            [0, 3, 9, 1, 4, 8, 2, 5, 7],
            [1, 0, 8, 0, 0, 0, 0, 6, 3],
            [0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 2, 0, 0, 0, 0],
            [0, 0, 0, 9, 0, 0, 1, 0, 6],
            [0, 0, 2, 6, 0, 0, 0, 0, 0],
            [8, 0, 1, 3, 9, 0, 0, 0, 5],
            [0, 0, 7, 8, 1, 0, 0, 0, 0],
            [0, 2, 3, 0, 5, 6, 9, 1, 0]
        ];

        $strategyExpectedOutput = [
            [6, 3, 9, 1, 4, 8, 2, 5, 7],
            [1, 0, 8, 0, 0, 0, 0, 6, 3],
            [0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 2, 0, 0, 0, 0],
            [0, 0, 0, 9, 0, 0, 1, 0, 6],
            [0, 0, 2, 6, 0, 0, 0, 0, 0],
            [8, 0, 1, 3, 9, 0, 0, 0, 5],
            [0, 0, 7, 8, 1, 0, 0, 0, 0],
            [0, 2, 3, 0, 5, 6, 9, 1, 0]
        ];

        $this->assertStrategyOutput($strategyInput, $strategyExpectedOutput);
    }

    /**
     */
    public function testMultipleRow(): void
    {
        $strategyInput = [
            [0, 3, 9, 1, 4, 8, 2, 5, 7],
            [1, 5, 8, 2, 7, 9, 0, 6, 3],
            [0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 2, 0, 0, 0, 0],
            [0, 0, 0, 9, 0, 0, 1, 0, 6],
            [0, 0, 2, 6, 0, 0, 0, 0, 0],
            [8, 6, 1, 3, 9, 0, 7, 4, 5],
            [0, 0, 7, 8, 1, 0, 0, 0, 0],
            [0, 2, 3, 0, 5, 6, 9, 1, 0]
        ];

        $strategyExpectedOutput = [
            [6, 3, 9, 1, 4, 8, 2, 5, 7],
            [1, 5, 8, 2, 7, 9, 4, 6, 3],
            [0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 2, 0, 0, 0, 0],
            [0, 0, 0, 9, 0, 0, 1, 0, 6],
            [0, 0, 2, 6, 0, 0, 0, 0, 0],
            [8, 6, 1, 3, 9, 2, 7, 4, 5],
            [0, 0, 7, 8, 1, 0, 0, 0, 0],
            [0, 2, 3, 0, 5, 6, 9, 1, 0]
        ];

        $this->assertStrategyOutput($strategyInput, $strategyExpectedOutput);
    }

    /**
     */
    public function testSingleColumn(): void
    {
        $strategyInput = [
            [0, 3, 9, 1, 4, 8, 2, 5, 7],
            [1, 0, 8, 0, 7, 0, 0, 6, 3],
            [0, 0, 0, 0, 6, 0, 0, 0, 0],
            [0, 0, 0, 0, 2, 0, 0, 0, 0],
            [0, 0, 0, 9, 0, 0, 1, 0, 6],
            [0, 0, 2, 6, 3, 0, 0, 0, 0],
            [8, 0, 1, 3, 9, 0, 0, 0, 5],
            [0, 0, 7, 8, 1, 0, 0, 0, 0],
            [0, 2, 3, 0, 5, 6, 9, 1, 0]
        ];

        $strategyExpectedOutput = [
            [6, 3, 9, 1, 4, 8, 2, 5, 7],
            [1, 0, 8, 0, 7, 0, 0, 6, 3],
            [0, 0, 0, 0, 6, 0, 0, 0, 0],
            [0, 0, 0, 0, 2, 0, 0, 0, 0],
            [0, 0, 0, 9, 8, 0, 1, 0, 6],
            [0, 0, 2, 6, 3, 0, 0, 0, 0],
            [8, 0, 1, 3, 9, 0, 0, 0, 5],
            [0, 0, 7, 8, 1, 0, 0, 0, 0],
            [0, 2, 3, 0, 5, 6, 9, 1, 0]
        ];

        $this->assertStrategyOutput($strategyInput, $strategyExpectedOutput);
    }

    /**
     */
    public function testMultipleColumn(): void
    {
        $strategyInput = [
            [6, 3, 9, 1, 4, 8, 2, 5, 7],
            [1, 0, 8, 0, 7, 0, 0, 6, 3],
            [0, 0, 0, 0, 6, 0, 0, 9, 0],
            [0, 0, 0, 0, 2, 0, 0, 8, 0],
            [0, 0, 0, 9, 0, 0, 1, 2, 6],
            [0, 0, 2, 6, 3, 0, 0, 7, 0],
            [8, 0, 1, 3, 9, 0, 0, 4, 5],
            [0, 0, 7, 8, 1, 0, 0, 3, 0],
            [0, 2, 3, 0, 5, 6, 9, 1, 0]
        ];

        $strategyExpectedOutput = [
            [6, 3, 9, 1, 4, 8, 2, 5, 7],
            [1, 0, 8, 0, 7, 0, 0, 6, 3],
            [0, 0, 0, 0, 6, 0, 0, 9, 0],
            [0, 0, 0, 0, 2, 0, 0, 8, 0],
            [0, 0, 0, 9, 8, 0, 1, 2, 6],
            [0, 0, 2, 6, 3, 0, 0, 7, 0],
            [8, 0, 1, 3, 9, 0, 0, 4, 5],
            [0, 0, 7, 8, 1, 0, 0, 3, 0],
            [0, 2, 3, 0, 5, 6, 9, 1, 0]
        ];

        $this->assertStrategyOutput($strategyInput, $strategyExpectedOutput);
    }

    /**
     */
    public function testSingleRegion(): void
    {
        $strategyInput = [
            [6, 3, 9, 0, 0, 8, 2, 5, 7],
            [1, 0, 8, 0, 0, 9, 4, 6, 3],
            [2, 7, 4, 0, 0, 3, 8, 9, 1],
            [0, 0, 0, 0, 0, 5, 3, 8, 9],
            [0, 0, 0, 0, 0, 7, 1, 2, 6],
            [9, 8, 2, 6, 3, 1, 5, 7, 4],
            [8, 6, 1, 3, 9, 2, 7, 4, 5],
            [5, 9, 7, 8, 1, 4, 6, 3, 2],
            [4, 2, 3, 7, 5, 6, 9, 1, 8]
        ];

        $strategyExpectedOutput = [
            [6, 3, 9, 0, 0, 8, 2, 5, 7],
            [1, 5, 8, 0, 0, 9, 4, 6, 3],
            [2, 7, 4, 0, 0, 3, 8, 9, 1],
            [0, 0, 0, 0, 0, 5, 3, 8, 9],
            [0, 0, 0, 0, 0, 7, 1, 2, 6],
            [9, 8, 2, 6, 3, 1, 5, 7, 4],
            [8, 6, 1, 3, 9, 2, 7, 4, 5],
            [5, 9, 7, 8, 1, 4, 6, 3, 2],
            [4, 2, 3, 7, 5, 6, 9, 1, 8]
        ];

        $this->assertStrategyOutput($strategyInput, $strategyExpectedOutput);
    }

    /**
     */
    public function testMultipleRegion(): void
    {
        $strategyInput = [
            [6, 3, 9, 0, 0, 8, 2, 5, 7],
            [1, 0, 8, 0, 0, 9, 4, 6, 3],
            [2, 7, 4, 0, 0, 3, 8, 9, 1],
            [0, 0, 0, 0, 0, 5, 3, 8, 9],
            [0, 0, 0, 0, 0, 7, 1, 2, 6],
            [9, 8, 0, 0, 0, 0, 0, 7, 4],
            [8, 6, 0, 3, 9, 2, 0, 4, 5],
            [5, 9, 0, 8, 1, 4, 0, 3, 2],
            [4, 2, 0, 7, 5, 0, 0, 1, 8]
        ];

        $strategyExpectedOutput = [
            [6, 3, 9, 0, 0, 8, 2, 5, 7],
            [1, 5, 8, 0, 0, 9, 4, 6, 3],
            [2, 7, 4, 0, 0, 3, 8, 9, 1],
            [0, 0, 0, 0, 0, 5, 3, 8, 9],
            [0, 0, 0, 0, 0, 7, 1, 2, 6],
            [9, 8, 0, 0, 0, 0, 5, 7, 4],
            [8, 6, 0, 3, 9, 2, 0, 4, 5],
            [5, 9, 0, 8, 1, 4, 0, 3, 2],
            [4, 2, 0, 7, 5, 6, 0, 1, 8]
        ];

        $this->assertStrategyOutput($strategyInput, $strategyExpectedOutput);
    }

    /**
     */
    public function testSingleEmptyCells(): void
    {
        $strategyInput = [
            [0, 3, 9, 1, 4, 8, 2, 5, 7],
            [1, 5, 8, 2, 7, 9, 4, 6, 3],
            [2, 7, 4, 5, 6, 3, 8, 9, 1],
            [7, 1, 6, 4, 2, 5, 3, 8, 9],
            [3, 4, 5, 9, 8, 7, 1, 2, 6],
            [9, 8, 2, 6, 3, 1, 5, 7, 4],
            [8, 6, 1, 3, 9, 2, 7, 4, 5],
            [5, 9, 7, 8, 1, 4, 6, 3, 2],
            [4, 2, 3, 7, 5, 6, 9, 1, 8]
        ];

        $strategyExpectedOutput = [
            [6, 3, 9, 1, 4, 8, 2, 5, 7],
            [1, 5, 8, 2, 7, 9, 4, 6, 3],
            [2, 7, 4, 5, 6, 3, 8, 9, 1],
            [7, 1, 6, 4, 2, 5, 3, 8, 9],
            [3, 4, 5, 9, 8, 7, 1, 2, 6],
            [9, 8, 2, 6, 3, 1, 5, 7, 4],
            [8, 6, 1, 3, 9, 2, 7, 4, 5],
            [5, 9, 7, 8, 1, 4, 6, 3, 2],
            [4, 2, 3, 7, 5, 6, 9, 1, 8]
        ];

        $this->assertStrategyOutput($strategyInput, $strategyExpectedOutput);
    }

    /**
     */
    public function testNoEmptyCells(): void
    {
        $solvedStrategy = [
            [6, 3, 9, 1, 4, 8, 2, 5, 7],
            [1, 5, 8, 2, 7, 9, 4, 6, 3],
            [2, 7, 4, 5, 6, 3, 8, 9, 1],
            [7, 1, 6, 4, 2, 5, 3, 8, 9],
            [3, 4, 5, 9, 8, 7, 1, 2, 6],
            [9, 8, 2, 6, 3, 1, 5, 7, 4],
            [8, 6, 1, 3, 9, 2, 7, 4, 5],
            [5, 9, 7, 8, 1, 4, 6, 3, 2],
            [4, 2, 3, 7, 5, 6, 9, 1, 8]
        ];

        $this->assertStrategyOutput($solvedStrategy, $solvedStrategy);
    }

    /**
     * @param array $strategyInput
     * @param array $strategyExpectedOutput
     */
    private function assertStrategyOutput(array $strategyInput, array $strategyExpectedOutput)
    {
        $puzzle = new Puzzle($strategyInput);
        $strategyOneChoiceOnly = new StrategyOneChoiceOnly($puzzle);
        $solvedPuzzle = $strategyOneChoiceOnly->applyStrategy();

        static::assertEquals($strategyExpectedOutput, $solvedPuzzle->getPuzzleArray());
    }
}
