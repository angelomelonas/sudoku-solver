<?php

declare(strict_types=1);

namespace AngeloMelonas\SudokuSolverTest;

use PHPUnit\Framework\TestCase;

final class BasicTest extends TestCase
{

    public function tearDown()
    {
        parent::tearDown();
    }

    /** @test */
    public function main()
    {
        echo "Running basic tests...";
        $this->basicFirstTest();
    }

    private function basicFirstTest()
    {
        $this->assertEquals(true, true);
    }
}
