<?php

namespace sudoku\solver\test;

use PHPUnit\Framework\TestCase;
use sudoku\solver\puzzle\code\Puzzle;
use sudoku\solver\strategy\StrategyOnlySquare;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200203 Initial creation.
 */
class StrategyOnlySquareTest extends TestCase
{
    /**
     */
    public function testBasic()
    {
        $strategyInput = [
            [2, 6, 1, 4, 9, 5, 8, 7, 3],
            [9, 0, 8, 1, 7, 6, 0, 4, 5],
            [7, 0, 0, 8, 3, 2, 0, 0, 6],
            [1, 2, 6, 9, 8, 7, 0, 0, 4],
            [3, 8, 0, 6, 5, 4, 0, 2, 7],
            [4, 0, 0, 3, 2, 1, 6, 8, 9],
            [5, 0, 0, 7, 6, 3, 0, 0, 8],
            [6, 9, 0, 5, 1, 8, 7, 0, 2],
            [8, 7, 3, 2, 4, 9, 5, 6, 1],
        ];

        $strategyExpectedOutput = [
            [2, 6, 1, 4, 9, 5, 8, 7, 3],
            [9, 3, 8, 1, 7, 6, 0, 4, 5],
            [7, 0, 0, 8, 3, 2, 0, 0, 6],
            [1, 2, 6, 9, 8, 7, 0, 0, 4],
            [3, 8, 0, 6, 5, 4, 0, 2, 7],
            [4, 0, 0, 3, 2, 1, 6, 8, 9],
            [5, 0, 0, 7, 6, 3, 0, 0, 8],
            [6, 9, 0, 5, 1, 8, 7, 0, 2],
            [8, 7, 3, 2, 4, 9, 5, 6, 1],
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
        $strategyOnlySquare = new StrategyOnlySquare($puzzle);
        $solvedPuzzle = $strategyOnlySquare->applyStrategy();

        static::assertEquals($strategyExpectedOutput, $solvedPuzzle->getPuzzleArray());
    }
}
