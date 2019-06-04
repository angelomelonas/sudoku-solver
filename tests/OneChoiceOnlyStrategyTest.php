<?php

declare(strict_types=1);

namespace AngeloMelonas\SudokuSolverTest;

use AngeloMelonas\SudokuSolver\Strategies\OneChoiceOnly;
use PHPUnit\Framework\TestCase;

class OneChoiceOnlyStrategyTest extends TestCase
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

        $this->assertStrategyOutput($strategyInput, $strategyExpectedOutput);
    }

    /**
     * @test
     */
    public function singleColumnTest(): void
    {
        $strategyInput = array(
            array(0, 3, 9, 1, 4, 8, 2, 5, 7),
            array(1, 0, 8, 0, 7, 0, 0, 6, 3),
            array(0, 0, 0, 0, 6, 0, 0, 0, 0),
            array(0, 0, 0, 0, 2, 0, 0, 0, 0),
            array(0, 0, 0, 9, 0, 0, 1, 0, 6),
            array(0, 0, 2, 6, 3, 0, 0, 0, 0),
            array(8, 0, 1, 3, 9, 0, 0, 0, 5),
            array(0, 0, 7, 8, 1, 0, 0, 0, 0),
            array(0, 2, 3, 0, 5, 6, 9, 1, 0));

        $strategyExpectedOutput = array(
            array(6, 3, 9, 1, 4, 8, 2, 5, 7),
            array(1, 0, 8, 0, 7, 0, 0, 6, 3),
            array(0, 0, 0, 0, 6, 0, 0, 0, 0),
            array(0, 0, 0, 0, 2, 0, 0, 0, 0),
            array(0, 0, 0, 9, 8, 0, 1, 0, 6),
            array(0, 0, 2, 6, 3, 0, 0, 0, 0),
            array(8, 0, 1, 3, 9, 0, 0, 0, 5),
            array(0, 0, 7, 8, 1, 0, 0, 0, 0),
            array(0, 2, 3, 0, 5, 6, 9, 1, 0));

        $this->assertStrategyOutput($strategyInput, $strategyExpectedOutput);
    }

    /**
     * @test
     */
    public function multipleColumnTest(): void
    {
        $strategyInput = array(
            array(6, 3, 9, 1, 4, 8, 2, 5, 7),
            array(1, 0, 8, 0, 7, 0, 0, 6, 3),
            array(0, 0, 0, 0, 6, 0, 0, 9, 0),
            array(0, 0, 0, 0, 2, 0, 0, 8, 0),
            array(0, 0, 0, 9, 0, 0, 1, 2, 6),
            array(0, 0, 2, 6, 3, 0, 0, 7, 0),
            array(8, 0, 1, 3, 9, 0, 0, 4, 5),
            array(0, 0, 7, 8, 1, 0, 0, 3, 0),
            array(0, 2, 3, 0, 5, 6, 9, 1, 0));

        $strategyExpectedOutput = array(
            array(6, 3, 9, 1, 4, 8, 2, 5, 7),
            array(1, 0, 8, 0, 7, 0, 0, 6, 3),
            array(0, 0, 0, 0, 6, 0, 0, 9, 0),
            array(0, 0, 0, 0, 2, 0, 0, 8, 0),
            array(0, 0, 0, 9, 8, 0, 1, 2, 6),
            array(0, 0, 2, 6, 3, 0, 0, 7, 0),
            array(8, 0, 1, 3, 9, 0, 0, 4, 5),
            array(0, 0, 7, 8, 1, 0, 0, 3, 0),
            array(0, 2, 3, 0, 5, 6, 9, 1, 0));

        $this->assertStrategyOutput($strategyInput, $strategyExpectedOutput);
    }

    /**
     * @test
     */
    public function singleRegionTest(): void
    {
        $strategyInput = array(
            array(6, 3, 9, 0, 0, 8, 2, 5, 7),
            array(1, 0, 8, 0, 0, 9, 4, 6, 3),
            array(2, 7, 4, 0, 0, 3, 8, 9, 1),
            array(0, 0, 0, 0, 0, 5, 3, 8, 9),
            array(0, 0, 0, 0, 0, 7, 1, 2, 6),
            array(9, 8, 2, 6, 3, 1, 5, 7, 4),
            array(8, 6, 1, 3, 9, 2, 7, 4, 5),
            array(5, 9, 7, 8, 1, 4, 6, 3, 2),
            array(4, 2, 3, 7, 5, 6, 9, 1, 8));

        $strategyExpectedOutput = array(
            array(6, 3, 9, 0, 0, 8, 2, 5, 7),
            array(1, 5, 8, 0, 0, 9, 4, 6, 3),
            array(2, 7, 4, 0, 0, 3, 8, 9, 1),
            array(0, 0, 0, 0, 0, 5, 3, 8, 9),
            array(0, 0, 0, 0, 0, 7, 1, 2, 6),
            array(9, 8, 2, 6, 3, 1, 5, 7, 4),
            array(8, 6, 1, 3, 9, 2, 7, 4, 5),
            array(5, 9, 7, 8, 1, 4, 6, 3, 2),
            array(4, 2, 3, 7, 5, 6, 9, 1, 8));

        $this->assertStrategyOutput($strategyInput, $strategyExpectedOutput);
    }

    /**
     * @test
     */
    public function multipleRegionTest(): void
    {
        $strategyInput = array(
            array(6, 3, 9, 0, 0, 8, 2, 5, 7),
            array(1, 0, 8, 0, 0, 9, 4, 6, 3),
            array(2, 7, 4, 0, 0, 3, 8, 9, 1),
            array(0, 0, 0, 0, 0, 5, 3, 8, 9),
            array(0, 0, 0, 0, 0, 7, 1, 2, 6),
            array(9, 8, 0, 0, 0, 0, 0, 7, 4),
            array(8, 6, 0, 3, 9, 2, 0, 4, 5),
            array(5, 9, 0, 8, 1, 4, 0, 3, 2),
            array(4, 2, 0, 7, 5, 0, 0, 1, 8));

        $strategyExpectedOutput = array(
            array(6, 3, 9, 0, 0, 8, 2, 5, 7),
            array(1, 5, 8, 0, 0, 9, 4, 6, 3),
            array(2, 7, 4, 0, 0, 3, 8, 9, 1),
            array(0, 0, 0, 0, 0, 5, 3, 8, 9),
            array(0, 0, 0, 0, 0, 7, 1, 2, 6),
            array(9, 8, 0, 0, 0, 0, 5, 7, 4),
            array(8, 6, 0, 3, 9, 2, 0, 4, 5),
            array(5, 9, 0, 8, 1, 4, 0, 3, 2),
            array(4, 2, 0, 7, 5, 6, 0, 1, 8));

        $this->assertStrategyOutput($strategyInput, $strategyExpectedOutput);
    }

    /**
     * @test
     */
    public function singleEmptyCellsTest(): void
    {
        $strategyInput = array(
            array(0, 3, 9, 1, 4, 8, 2, 5, 7),
            array(1, 5, 8, 2, 7, 9, 4, 6, 3),
            array(2, 7, 4, 5, 6, 3, 8, 9, 1),
            array(7, 1, 6, 4, 2, 5, 3, 8, 9),
            array(3, 4, 5, 9, 8, 7, 1, 2, 6),
            array(9, 8, 2, 6, 3, 1, 5, 7, 4),
            array(8, 6, 1, 3, 9, 2, 7, 4, 5),
            array(5, 9, 7, 8, 1, 4, 6, 3, 2),
            array(4, 2, 3, 7, 5, 6, 9, 1, 8));

        $strategyExpectedOutput = array(
            array(6, 3, 9, 1, 4, 8, 2, 5, 7),
            array(1, 5, 8, 2, 7, 9, 4, 6, 3),
            array(2, 7, 4, 5, 6, 3, 8, 9, 1),
            array(7, 1, 6, 4, 2, 5, 3, 8, 9),
            array(3, 4, 5, 9, 8, 7, 1, 2, 6),
            array(9, 8, 2, 6, 3, 1, 5, 7, 4),
            array(8, 6, 1, 3, 9, 2, 7, 4, 5),
            array(5, 9, 7, 8, 1, 4, 6, 3, 2),
            array(4, 2, 3, 7, 5, 6, 9, 1, 8));

        $this->assertStrategyOutput($strategyInput, $strategyExpectedOutput);
    }

    /**
     * @test
     */
    public function noEmptyCellsTest(): void
    {
        $solvedStrategy = array(
            array(6, 3, 9, 1, 4, 8, 2, 5, 7),
            array(1, 5, 8, 2, 7, 9, 4, 6, 3),
            array(2, 7, 4, 5, 6, 3, 8, 9, 1),
            array(7, 1, 6, 4, 2, 5, 3, 8, 9),
            array(3, 4, 5, 9, 8, 7, 1, 2, 6),
            array(9, 8, 2, 6, 3, 1, 5, 7, 4),
            array(8, 6, 1, 3, 9, 2, 7, 4, 5),
            array(5, 9, 7, 8, 1, 4, 6, 3, 2),
            array(4, 2, 3, 7, 5, 6, 9, 1, 8));

        $this->assertStrategyOutput($solvedStrategy, $solvedStrategy);
    }

    private function assertStrategyOutput(array $strategyInput, array $strategyExpectedOutput)
    {
        $M = count($strategyInput[0]);
        $oneChoiceOnlyStrategy = new OneChoiceOnly($M);
        $puzzlePostStrategy = $oneChoiceOnlyStrategy->applyStrategy($strategyInput);
        $this->assertEquals($strategyExpectedOutput, $puzzlePostStrategy);
    }
}
