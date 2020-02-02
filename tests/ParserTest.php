<?php

namespace sudoku\solver\test;

use Exception;
use PHPUnit\Framework\TestCase;
use sudoku\solver\common\exception\SudokuSolverException;
use sudoku\solver\parser\exception\SudokuSolverExceptionParser;
use sudoku\solver\parser\PuzzleParser;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200201 Initial creation.
 */
class ParserTest extends TestCase
{
    /**
     * Puzzle filepath constants.
     */
    const PATH_BASIC_PUZZLE = '/puzzles/very_easy_1.puzzle';

    /**
     * Exception constants.
     */
    const ERROR_PUZZLE_DIMENSIONS_INVALID = 'The puzzle dimensions have to be square.';
    const ERROR_PUZZLE_CAN_ONLY_CONTAIN_POSITIVE_NUMBERS = '"%s" is an invalid cell value. The puzzle can only contain positive numbers.';
    const ERROR_PUZZLE_ROW_INVALID = 'Line %s in puzzle or file is not a valid row.';

    /**
     * @throws Exception
     */
    public function testParser(): void
    {
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

        $parserExpectedOutput = [
            [0, 0, 0, 1, 9, 0, 5, 8, 2],
            [5, 0, 8, 0, 2, 7, 0, 0, 9],
            [2, 9, 4, 8, 0, 0, 7, 0, 0],
            [0, 0, 6, 3, 7, 0, 0, 9, 4],
            [4, 3, 0, 0, 6, 2, 0, 5, 0],
            [9, 8, 0, 4, 0, 5, 6, 0, 0],
            [8, 0, 1, 0, 0, 0, 0, 2, 5],
            [0, 0, 9, 5, 8, 1, 4, 7, 0],
            [0, 7, 0, 2, 0, 9, 1, 6, 0]
        ];

        $puzzle = PuzzleParser::parsePuzzleFromString($parserInput);

        static::assertEquals($parserExpectedOutput, $puzzle->getPuzzleArray());
    }

    /**
     * @throws SudokuSolverException
     */
    public function testParserWithFile(): void
    {
        $parserExpectedOutput = [
            [0, 0, 0, 1, 9, 0, 5, 8, 2],
            [5, 0, 8, 0, 2, 7, 0, 0, 9],
            [2, 9, 4, 8, 0, 0, 7, 0, 0],
            [0, 0, 6, 3, 7, 0, 0, 9, 4],
            [4, 3, 0, 0, 6, 2, 0, 5, 0],
            [9, 8, 0, 4, 0, 5, 6, 0, 0],
            [8, 0, 1, 0, 0, 0, 0, 2, 5],
            [0, 0, 9, 5, 8, 1, 4, 7, 0],
            [0, 7, 0, 2, 0, 9, 1, 6, 0]
        ];

        $puzzle = PuzzleParser::parsePuzzleFromFile(self::PATH_BASIC_PUZZLE);

        static::assertEquals($parserExpectedOutput, $puzzle->getPuzzleArray());
    }

    /**
     * @throws SudokuSolverExceptionParser
     */
    public function testParserIncorrectPuzzleDimensionsException(): void
    {
        $parserInput =
            "0, 0, 0, 1, 9, 0, 5, 8, 2
            5, 0, 8, 0, 2, 7, 0, 0, 9
            2, 9, 4, 8, 0, 0, 7, 0, 0
            0, 0, 6, 3, 7, 0, 0, 9, 4
            4, 3, 0, 0, 6, 2, 0, 5, 0
            9, 8, 0, 4, 0, 5, 6, 0
            8, 0, 1, 0, 0, 0, 0, 2, 5
            0, 0, 9, 5, 8, 1, 4, 7, 0
            0, 7, 0, 2, 0, 9, 1, 6, 0";

        $this->expectException(Exception::class);
        $this->expectExceptionMessage(self::ERROR_PUZZLE_DIMENSIONS_INVALID);

        PuzzleParser::parsePuzzleFromString($parserInput);
    }

    /**
     * @throws SudokuSolverExceptionParser
     */
    public function testParserNegativeNumberException(): void
    {
        $parserInput =
            "0, 0, 0, 1, 9, 0, 5, 8, -2
            5, 0, 8, 0, 2, 7, 0, 0, 9
            2, 9, 4, 8, 0, 0, 7, 0, 0
            0, 0, 6, 3, 7, 0, 0, 9, 4
            4, 3, 0, 0, 6, 2, 0, 5, 0
            9, 8, 0, 4, 0, 5, 6, 0, 0
            8, 0, 1, 0, 0, 0, 0, 2, 5
            0, 0, 9, 5, 8, 1, 4, 7, 0
            0, 7, 0, 2, 0, 9, 1, 6, 0";

        $negativeNumber = -2;

        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            vsprintf(self::ERROR_PUZZLE_CAN_ONLY_CONTAIN_POSITIVE_NUMBERS, [$negativeNumber])
        );

        PuzzleParser::parsePuzzleFromString($parserInput);
    }

    /**
     * @throws SudokuSolverExceptionParser
     */
    public function testParserInvalidRowException(): void
    {
        $parserInput =
            "0, 0, 0, 1, 9, 0, 5, 8, 2
            5, 0, 8, 0, 2, 7, 0, 0, 9
            2, 9, 4, 8, 0, 0, 7, 0, 0
            0, 0, 6, 3, 7, 0, 0, 9, 4
            invalid _ characters $ in row
            9, 8, 0, 4, 0, 5, 6, 0, 0
            8, 0, 1, 0, 0, 0, 0, 2, 5
            0, 0, 9, 5, 8, 1, 4, 7, 0
            0, 7, 0, 2, 0, 9, 1, 6, 0";

        $lineCount = 5;

        $this->expectException(Exception::class);
        $this->expectExceptionMessage(vsprintf(self::ERROR_PUZZLE_ROW_INVALID, [$lineCount]));

        PuzzleParser::parsePuzzleFromString($parserInput);
    }
}
