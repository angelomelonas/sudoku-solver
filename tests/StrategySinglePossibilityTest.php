<?php

namespace sudoku\solver\test;

use PHPUnit\Framework\TestCase;
use sudoku\solver\common\object\Puzzle;
use sudoku\solver\strategy\StrategySinglePossibility;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200202 Initial creation.
 */
class StrategySinglePossibilityTest extends TestCase
{
    /**
     */
    public function testBasic()
    {
        $strategyInput = [
            [8, 2, 5, 6, 3, 1, 9, 7, 4],
            [0, 6, 7, 0, 2, 4, 0, 0, 8],
            [4, 0, 0, 0, 0, 7, 6, 0, 2],
            [0, 5, 9, 0, 4, 8, 2, 6, 1],
            [1, 0, 8, 2, 6, 9, 7, 4, 5],
            [0, 4, 0, 1, 7, 5, 0, 8, 0],
            [3, 0, 1, 4, 0, 0, 0, 0, 0],
            [5, 0, 0, 0, 0, 3, 4, 0, 0],
            [2, 9, 4, 0, 0, 6, 5, 0, 0]
        ];

        $strategyExpectedOutput = [
            [8, 2, 5, 6, 3, 1, 9, 7, 4],
            [0, 6, 7, 0, 2, 4, 0, 0, 8],
            [4, 0, 0, 0, 0, 7, 6, 0, 2],
            [7, 5, 9, 0, 4, 8, 2, 6, 1],
            [1, 0, 8, 2, 6, 9, 7, 4, 5],
            [0, 4, 0, 1, 7, 5, 0, 8, 0],
            [3, 0, 1, 4, 0, 0, 0, 0, 0],
            [5, 0, 0, 0, 0, 3, 4, 0, 0],
            [2, 9, 4, 0, 0, 6, 5, 0, 0]
        ];

        $this->assertStrategyOutput($strategyInput, $strategyExpectedOutput);
    }

    /**
     * @param array $strategyInput
     * @param array $strategyExpectedOutput
     */
    private function assertStrategyOutput(array $strategyInput, array $strategyExpectedOutput)
    {
        $puzzle = new Puzzle($strategyInput);
        $strategySinglePossibility = new StrategySinglePossibility($puzzle);
        $solvedPuzzle = $strategySinglePossibility->applyStrategy();

        static::assertEquals($strategyExpectedOutput, $solvedPuzzle->getPuzzleArray());
    }
}
