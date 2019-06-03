<?php

declare(strict_types=1);

namespace AngeloMelonas\SudokuSolverTest;

use AngeloMelonas\SudokuSolver\Solver;

use PHPUnit\Framework\TestCase;

class SolverTest extends TestCase {
    /**
     * @test
     */
    public function basicSolverTest() {
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

        $solver = new Solver($puzzleInput);

        $this->assertEquals($puzzleExpectedOutput, $solver->solve());
    }
}
