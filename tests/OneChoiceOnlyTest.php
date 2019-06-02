<?php

declare(strict_types=1);

namespace AngeloMelonas\SudokuSolverTest;

use AngeloMelonas\SudokuSolver\Strategies\OneChoiceOnly;
use PHPUnit\Framework\TestCase;

class OneChoiceOnlyTest extends TestCase
{
    /**
     * @test
     */
    public function singleRowTest(): void
    {
        $strategyInput = array(
            array(0, 3, 9, 1, 4, 8, 2, 5, 7),
            array(1, 0, 8, 0, 0, 0, 0, 6, 3),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 2, 0, 0, 0, 0),
            array(0, 0, 0, 9, 0, 0, 1, 0, 6),
            array(0, 0, 2, 6, 0, 0, 0, 0, 0),
            array(8, 0, 1, 3, 9, 0, 0, 0, 5),
            array(0, 0, 7, 8, 1, 0, 0, 0, 0),
            array(0, 2, 3, 0, 5, 6, 9, 1, 0));

        $strategyExpectedOutput = array(
            array(6, 3, 9, 1, 4, 8, 2, 5, 7),
            array(1, 0, 8, 0, 0, 0, 0, 6, 3),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 2, 0, 0, 0, 0),
            array(0, 0, 0, 9, 0, 0, 1, 0, 6),
            array(0, 0, 2, 6, 0, 0, 0, 0, 0),
            array(8, 0, 1, 3, 9, 0, 0, 0, 5),
            array(0, 0, 7, 8, 1, 0, 0, 0, 0),
            array(0, 2, 3, 0, 5, 6, 9, 1, 0));

        $M = count($strategyInput[0]);

        $oneChoiceOnlyStrategy = new OneChoiceOnly($M);

        $puzzlePostStrategy = $oneChoiceOnlyStrategy->applyStrategy($strategyInput);

        $this->assertEquals($strategyExpectedOutput, $puzzlePostStrategy);
    }

    /**
     * @test
     */
    public function multipleRowTest(): void
    {
        $strategyInput = array(
            array(0, 3, 9, 1, 4, 8, 2, 5, 7),
            array(1, 5, 8, 2, 7, 9, 0, 6, 3),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 2, 0, 0, 0, 0),
            array(0, 0, 0, 9, 0, 0, 1, 0, 6),
            array(0, 0, 2, 6, 0, 0, 0, 0, 0),
            array(8, 6, 1, 3, 9, 0, 7, 4, 5),
            array(0, 0, 7, 8, 1, 0, 0, 0, 0),
            array(0, 2, 3, 0, 5, 6, 9, 1, 0));

        $strategyExpectedOutput = array(
            array(6, 3, 9, 1, 4, 8, 2, 5, 7),
            array(1, 5, 8, 2, 7, 9, 4, 6, 3),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 2, 0, 0, 0, 0),
            array(0, 0, 0, 9, 0, 0, 1, 0, 6),
            array(0, 0, 2, 6, 0, 0, 0, 0, 0),
            array(8, 6, 1, 3, 9, 2, 7, 4, 5),
            array(0, 0, 7, 8, 1, 0, 0, 0, 0),
            array(0, 2, 3, 0, 5, 6, 9, 1, 0));


        $M = count($strategyInput[0]);

        $oneChoiceOnlyStrategy = new OneChoiceOnly($M);

        $puzzlePostStrategy = $oneChoiceOnlyStrategy->applyStrategy($strategyInput);

        $this->assertEquals($strategyExpectedOutput, $puzzlePostStrategy);
    }
}
