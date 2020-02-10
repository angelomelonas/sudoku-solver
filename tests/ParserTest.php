<?php

namespace sudoku\solver\test;

use Exception;
use PHPUnit\Framework\TestCase;
use sudoku\solver\common\exception\SudokuSolverException;
use sudoku\solver\parser\exception\SudokuSolverExceptionParser;
use sudoku\solver\parser\Parser;

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
    const ERROR_PUZZLE_CAN_ONLY_CONTAIN_POSITIVE_NUMBERS = '"%s" is an invalid square value. ' .
    'The puzzle can only contain positive numbers.';
    const ERROR_PUZZLE_ROW_INVALID = 'Line %s in puzzle or file is not a valid row.';
    const ERROR_PUZZLE_MINIMUM_NUMBER_OF_CLUES_INVALID = 'The puzzle has %s clues. ' .
    'The minimum number of clues to be able to solve a given puzzle is %s.';
    const ERROR_PUZZLE_INVALID = 'A row, column or region of the puzzle is invalid.';

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

        $puzzle = Parser::parsePuzzleFromString($parserInput);

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

        $puzzle = Parser::parsePuzzleFromFile(self::PATH_BASIC_PUZZLE);

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

        $this->expectException(SudokuSolverExceptionParser::class);
        $this->expectExceptionMessage(self::ERROR_PUZZLE_DIMENSIONS_INVALID);

        Parser::parsePuzzleFromString($parserInput);
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

        $this->expectException(SudokuSolverExceptionParser::class);
        $this->expectExceptionMessage(
            vsprintf(self::ERROR_PUZZLE_CAN_ONLY_CONTAIN_POSITIVE_NUMBERS, [$negativeNumber])
        );

        Parser::parsePuzzleFromString($parserInput);
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

        $this->expectException(SudokuSolverExceptionParser::class);
        $this->expectExceptionMessage(vsprintf(self::ERROR_PUZZLE_ROW_INVALID, [$lineCount]));

        Parser::parsePuzzleFromString($parserInput);
    }

    /**
 * @throws Exception
 */
    public function testParserMinimumValuesInvalid(): void
    {
        $parserInput =
            "0, 0, 0, 0, 0, 1, 0, 0, 0
             0, 0, 0, 0, 0, 0, 4, 3, 0
             5, 0, 0, 0, 0, 0, 0, 0, 0
             0, 0, 0, 0, 7, 0, 8, 0, 0
             0, 0, 0, 0, 0, 0, 1, 0, 0
             0, 2, 0, 0, 3, 0, 0, 0, 0
             6, 0, 0, 0, 0, 0, 0, 7, 5
             0, 0, 3, 4, 0, 0, 0, 0, 0
             0, 0, 0, 2, 0, 0, 6, 0, 0";

        $this->expectException(SudokuSolverExceptionParser::class);
        $this->expectExceptionMessage(vsprintf(self::ERROR_PUZZLE_MINIMUM_NUMBER_OF_CLUES_INVALID, [16, 17]));

        Parser::parsePuzzleFromString($parserInput);
    }

    /**
     * @throws Exception
     */
    public function testParserPuzzleInvalid(): void
    {
        $parserInput =
            "0, 0, 0, 0, 0, 1, 0, 0, 0
             0, 0, 0, 0, 0, 0, 4, 3, 0
             5, 0, 0, 0, 0, 0, 0, 0, 0
             0, 0, 0, 0, 7, 0, 8, 0, 0
             0, 0, 0, 0, 0, 0, 1, 0, 0
             0, 2, 0, 0, 3, 0, 0, 0, 0
             6, 0, 6, 0, 0, 0, 0, 7, 5
             0, 0, 3, 4, 0, 0, 0, 0, 0
             0, 0, 0, 2, 0, 0, 6, 0, 0";

        $this->expectException(SudokuSolverExceptionParser::class);
        $this->expectExceptionMessage(self::ERROR_PUZZLE_INVALID);

        Parser::parsePuzzleFromString($parserInput);
    }
}
