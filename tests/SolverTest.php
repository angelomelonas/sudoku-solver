<?php

namespace sudoku\solver\test;

use PHPUnit\Framework\TestCase;
use sudoku\solver\common\object\Puzzle;
use sudoku\solver\solver\Solver;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200201 Initial creation.
 */
class SolverTest extends TestCase
{
    /**
     */
    public function testBasicSingleEmptyCellSolver()
    {
        $puzzleInput = [
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

        $puzzleExpectedOutput = [
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

        $this->assertSolverOutput($puzzleInput, $puzzleExpectedOutput);
    }

    /**
     */
    public function testBasicMultipleEmptyCellSolver()
    {
        $puzzleInput = [
            [0, 3, 9, 1, 4, 0, 2, 5, 0],
            [1, 5, 8, 2, 7, 9, 0, 6, 3],
            [2, 7, 4, 0, 6, 3, 8, 9, 1],
            [0, 1, 6, 4, 0, 5, 3, 8, 0],
            [3, 4, 5, 0, 8, 0, 0, 2, 6],
            [9, 8, 2, 6, 0, 1, 5, 7, 4],
            [0, 6, 1, 3, 9, 2, 0, 4, 5],
            [5, 9, 0, 8, 1, 4, 6, 3, 2],
            [4, 2, 3, 7, 5, 6, 9, 0, 8]
        ];

        $puzzleExpectedOutput = [
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

        $this->assertSolverOutput($puzzleInput, $puzzleExpectedOutput);
    }

    /**
     */
    public function testBasicOne()
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
            [9, 3, 8, 1, 7, 6, 2, 4, 5],
            [7, 4, 5, 8, 3, 2, 9, 1, 6],
            [1, 2, 6, 9, 8, 7, 3, 5, 4],
            [3, 8, 9, 6, 5, 4, 1, 2, 7],
            [4, 5, 7, 3, 2, 1, 6, 8, 9],
            [5, 1, 2, 7, 6, 3, 4, 9, 8],
            [6, 9, 4, 5, 1, 8, 7, 3, 2],
            [8, 7, 3, 2, 4, 9, 5, 6, 1],
        ];
    }

    /**
     * This is the hardest puzzle ever created. Apparently.
     */
    public function testHardestPuzzleEver()
    {
        $strategyInput = [
            [8, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 3, 6, 0, 0, 0, 0, 0],
            [0, 7, 0, 0, 9, 0, 2, 0, 0],
            [0, 5, 0, 0, 0, 7, 0, 0, 0],
            [0, 0, 0, 0, 4, 5, 7, 0, 0],
            [0, 0, 0, 1, 0, 0, 0, 3, 0],
            [0, 0, 1, 0, 0, 0, 0, 6, 8],
            [0, 0, 8, 5, 0, 0, 0, 1, 0],
            [0, 9, 0, 0, 0, 0, 4, 0, 0],
        ];

        $strategyExpectedOutput = [
            [8, 1, 2, 7, 5, 3, 6, 4, 9],
            [9, 4, 3, 6, 8, 2, 1, 7, 5],
            [6, 7, 5, 4, 9, 1, 2, 8, 3],
            [1, 5, 4, 2, 3, 7, 8, 9, 6],
            [3, 6, 9, 8, 4, 5, 7, 2, 1],
            [2, 8, 7, 1, 6, 9, 5, 3, 4],
            [5, 2, 1, 9, 7, 4, 3, 6, 8],
            [4, 3, 8, 5, 2, 6, 9, 1, 7],
            [7, 9, 6, 3, 1, 8, 4, 5, 2],
        ];

        // TODO: Run this test when all the strategies have been implemented.
    }


    /**
     * @param array $puzzleInput
     * @param array $puzzleExpectedOutput
     */
    private function assertSolverOutput(array $puzzleInput, array $puzzleExpectedOutput)
    {
        $puzzle = new Puzzle($puzzleInput);
        $solver = new Solver($puzzle);
        $solvedPuzzle = $solver->solvePuzzle();

        static::assertEquals($puzzleExpectedOutput, $solvedPuzzle->getPuzzleArray());
    }
}
