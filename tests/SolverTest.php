<?php

namespace sudoku\solver\test;

use PHPUnit\Framework\TestCase;
use sudoku\solver\solver\Solver;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200201 Initial creation.
 */
class SolverTest extends TestCase
{
    /**
     * @test
     */
    public function basicSingleEmptyCellSolverTest()
    {
        $puzzleInput = array(
            array(0, 3, 9, 1, 4, 8, 2, 5, 7),
            array(1, 5, 8, 2, 7, 9, 4, 6, 3),
            array(2, 7, 4, 5, 6, 3, 8, 9, 1),
            array(7, 1, 6, 4, 2, 5, 3, 8, 9),
            array(3, 4, 5, 9, 8, 7, 1, 2, 6),
            array(9, 8, 2, 6, 3, 1, 5, 7, 4),
            array(8, 6, 1, 3, 9, 2, 7, 4, 5),
            array(5, 9, 7, 8, 1, 4, 6, 3, 2),
            array(4, 2, 3, 7, 5, 6, 9, 1, 8));

        $puzzleExpectedOutput = array(
            array(6, 3, 9, 1, 4, 8, 2, 5, 7),
            array(1, 5, 8, 2, 7, 9, 4, 6, 3),
            array(2, 7, 4, 5, 6, 3, 8, 9, 1),
            array(7, 1, 6, 4, 2, 5, 3, 8, 9),
            array(3, 4, 5, 9, 8, 7, 1, 2, 6),
            array(9, 8, 2, 6, 3, 1, 5, 7, 4),
            array(8, 6, 1, 3, 9, 2, 7, 4, 5),
            array(5, 9, 7, 8, 1, 4, 6, 3, 2),
            array(4, 2, 3, 7, 5, 6, 9, 1, 8));

        $this->assertSolverOutput($puzzleInput, $puzzleExpectedOutput);
    }

    /**
     * @test
     */
    public function basicMultipleEmptyCellSolverTest()
    {
        $puzzleInput = array(
            array(0, 3, 9, 1, 4, 0, 2, 5, 0),
            array(1, 5, 8, 2, 7, 9, 0, 6, 3),
            array(2, 7, 4, 0, 6, 3, 8, 9, 1),
            array(0, 1, 6, 4, 0, 5, 3, 8, 0),
            array(3, 4, 5, 0, 8, 0, 0, 2, 6),
            array(9, 8, 2, 6, 0, 1, 5, 7, 4),
            array(0, 6, 1, 3, 9, 2, 0, 4, 5),
            array(5, 9, 0, 8, 1, 4, 6, 3, 2),
            array(4, 2, 3, 7, 5, 6, 9, 0, 8));

        $puzzleExpectedOutput = array(
            array(6, 3, 9, 1, 4, 8, 2, 5, 7),
            array(1, 5, 8, 2, 7, 9, 4, 6, 3),
            array(2, 7, 4, 5, 6, 3, 8, 9, 1),
            array(7, 1, 6, 4, 2, 5, 3, 8, 9),
            array(3, 4, 5, 9, 8, 7, 1, 2, 6),
            array(9, 8, 2, 6, 3, 1, 5, 7, 4),
            array(8, 6, 1, 3, 9, 2, 7, 4, 5),
            array(5, 9, 7, 8, 1, 4, 6, 3, 2),
            array(4, 2, 3, 7, 5, 6, 9, 1, 8));

        $this->assertSolverOutput($puzzleInput, $puzzleExpectedOutput);
    }


    private function assertSolverOutput(array $puzzleInput, array $puzzleExpectedOutput)
    {
        $solver = new Solver($puzzleInput);
        $this->assertEquals($puzzleExpectedOutput, $solver->solve());
    }
}
