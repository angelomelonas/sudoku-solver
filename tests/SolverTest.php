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
