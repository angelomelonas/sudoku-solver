<?php

declare(strict_types=1);

namespace AngeloMelonas\SudokuSolverTest;

use AngeloMelonas\SudokuSolver\PuzzleParser;
use PHPUnit\Framework\TestCase;


class ParserTest extends TestCase {

    public function tearDown() {
        parent::tearDown();
    }

    /** @test */
    public function main() {
        $this->basicParserTest();
        $this->basicParserWithFileTest();
    }

    public function basicParserTest() {
        $parserInput =
            "0, 0, 0, 1, 9, 0, 5, 8, 2
            5, 0, 8, 0, 2, 7, 0, 0, 9
            2, 9, 4, 8, 0, 0, 7, 0, 0
            0, 0, 6, 3, 7, 0, 0, 9, 4
            4, 3, 0, 0, 6, 2, 0, 5, 0
            9, 8, 0, 4, 0, 5, 6, 0, 0
            8, 0, 1, 0, 0, 0, 0, 2, 5
            0, 0, 9, 5, 8, 1, 4, 7, 0
            0, 7, 0, 2, 0, 9, 1, 6, 0";

        $parserExpectedOutput = array(
            array(0, 0, 0, 1, 9, 0, 5, 8, 2),
            array(5, 0, 8, 0, 2, 7, 0, 0, 9),
            array(2, 9, 4, 8, 0, 0, 7, 0, 0),
            array(0, 0, 6, 3, 7, 0, 0, 9, 4),
            array(4, 3, 0, 0, 6, 2, 0, 5, 0),
            array(9, 8, 0, 4, 0, 5, 6, 0, 0),
            array(8, 0, 1, 0, 0, 0, 0, 2, 5),
            array(0, 0, 9, 5, 8, 1, 4, 7, 0),
            array(0, 7, 0, 2, 0, 9, 1, 6, 0)
        );

        $parser = new PuzzleParser();

        $parser->parseFileContents($parserInput);

        $this->assertEquals($parserExpectedOutput, $parser->getAllPuzzles()[0]);
    }

    private function basicParserWithFileTest() {
        $parserExpectedOutput1 = array(
            array(0, 0, 0, 1, 9, 0, 5, 8, 2),
            array(5, 0, 8, 0, 2, 7, 0, 0, 9),
            array(2, 9, 4, 8, 0, 0, 7, 0, 0),
            array(0, 0, 6, 3, 7, 0, 0, 9, 4),
            array(4, 3, 0, 0, 6, 2, 0, 5, 0),
            array(9, 8, 0, 4, 0, 5, 6, 0, 0),
            array(8, 0, 1, 0, 0, 0, 0, 2, 5),
            array(0, 0, 9, 5, 8, 1, 4, 7, 0),
            array(0, 7, 0, 2, 0, 9, 1, 6, 0)
        );
        $parserExpectedOutput2 = array(
            array(0, 0, 4, 0, 0, 0, 9, 7, 0),
            array(7, 0, 0, 8, 5, 0, 6, 0, 1),
            array(5, 1, 0, 0, 6, 0, 0, 2, 0),
            array(0, 0, 0, 1, 0, 2, 0, 0, 0),
            array(0, 0, 0, 0, 0, 5, 0, 0, 0),
            array(0, 0, 0, 7, 0, 0, 0, 0, 0),
            array(6, 0, 7, 0, 0, 0, 2, 0, 0),
            array(4, 0, 0, 2, 0, 9, 0, 0, 8),
            array(0, 0, 8, 4, 0, 0, 0, 9, 0));

        $parser = new PuzzleParser("../puzzles/basic.puzzle");

        $this->assertEquals($parserExpectedOutput1, $parser->getAllPuzzles()[0]);
        $this->assertEquals($parserExpectedOutput2, $parser->getAllPuzzles()[1]);
    }
}
