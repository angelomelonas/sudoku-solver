<?php
declare(strict_types=1);

namespace AngeloMelonas\SudokuSolverTest;

use AngeloMelonas\SudokuSolver\Strategies\OnlySquare;
use PHPUnit\Framework\TestCase;

class OnlySquareStrategyTest extends TestCase
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

        $this->assertStrategyOutput($strategyInput, $strategyExpectedOutput);
    }

    private function assertStrategyOutput(array $strategyInput, array $strategyExpectedOutput)
    {
        $M = count($strategyInput[0]);
        $onlySquareStrategy = new OnlySquare($M);
        $puzzlePostStrategy = $onlySquareStrategy->applyStrategy($strategyInput);
        $this->assertEquals($strategyExpectedOutput, $puzzlePostStrategy);
    }
}
