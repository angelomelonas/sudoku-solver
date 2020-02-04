<?php

namespace sudoku\solver\test;

use PHPUnit\Framework\TestCase;
use sudoku\solver\puzzle\code\Puzzle;
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
            [0, 6, 7, 5, 2, 4, 1, 3, 8],
            [4, 1, 3, 8, 9, 7, 6, 5, 2],
            [0, 5, 9, 0, 4, 8, 2, 6, 1],
            [1, 0, 8, 2, 6, 9, 7, 4, 5],
            [0, 4, 0, 1, 7, 5, 0, 8, 9],
            [3, 7, 1, 4, 5, 0, 0, 9, 6],
            [5, 8, 0, 9, 1, 3, 4, 2, 7],
            [2, 9, 4, 7, 8, 6, 5, 1, 3]
        ];

        $strategyExpectedOutput = [
            [8, 2, 5, 6, 3, 1, 9, 7, 4],
            [9, 6, 7, 5, 2, 4, 1, 3, 8],
            [4, 1, 3, 8, 9, 7, 6, 5, 2],
            [7, 5, 9, 3, 4, 8, 2, 6, 1],
            [1, 3, 8, 2, 6, 9, 7, 4, 5],
            [6, 4, 2, 1, 7, 5, 3, 8, 9],
            [3, 7, 1, 4, 5, 2, 8, 9, 6],
            [5, 8, 6, 9, 1, 3, 4, 2, 7],
            [2, 9, 4, 7, 8, 6, 5, 1, 3]
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
