<?php

declare(strict_types=1);

namespace sudoku\solver\parser;

use Exception;
use sudoku\solver\common\exception\SudokuSolverException;
use sudoku\solver\common\exception\SudokuSolverExceptionFileSystem;
use sudoku\solver\common\exception\SudokuSolverExceptionPuzzleNotFound;
use sudoku\solver\common\object\FileContent;
use sudoku\solver\common\object\FilePath;
use sudoku\solver\common\util\Settings;
use sudoku\solver\parser\exception\SudokuSolverExceptionParser;
use sudoku\solver\puzzle\code\Puzzle;
use sudoku\solver\puzzle\lib\PuzzleLib;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200201 Initial creation.
 */
class Parser
{
    /**
     * Error constants.
     */
    const ERROR_PUZZLE_NOT_FOUND = 'The puzzle was not found in "%s".';
    const ERROR_FAILED_FILE_GET_CONTENTS = 'Failed to get the contents of file "%s".';
    const ERROR_PUZZLE_CAN_ONLY_CONTAIN_POSITIVE_NUMBERS = '"%s" is an invalid square value. ' .
    'The puzzle can only contain positive numbers.';
    const ERROR_PUZZLE_DIMENSIONS_INVALID = 'The puzzle dimensions have to be square.';
    const ERROR_PUZZLE_MINIMUM_NUMBER_OF_CLUES_INVALID = 'The puzzle has %s clues. ' .
    'The minimum number of clues to be able to solve a given puzzle is %s.';
    const ERROR_PUZZLE_ROW_INVALID = 'Line %s in puzzle or file is not a valid row.';
    const ERROR_PUZZLE_SOLUTION_INVALID = 'The puzzle solution on line %s is invalid: %s';
    const ERROR_PUZZLE_INVALID = 'A row, column or region of the puzzle is invalid.';

    /**
     * Puzzle parser constants.
     */
    const PUZZLE_PARSER_MINIUM_NUMBER_OF_CLUES = 17;

    /**
     * File content constants.
     */
    const FILE_CONTENT_NEWLINE = "\n";

    /**
     * Delimiter constants.
     */
    const DELIMITER_HASH = "#";
    const DELIMITER_EMPTY = "";
    const DELIMITER_COMMA = ",";
    const DELIMITER_PERIOD = ".";
    const DELIMITER_ZERO = "0";

    /**
     * Split-length constants.
     */
    const SPLIT_LENGTH_ONE = 1;
    const SPLIT_LENGTH_EIGTEEN = 18;

    /**
     * @param string $puzzleString
     *
     * @return Puzzle
     * @throws SudokuSolverExceptionParser
     */
    public static function parsePuzzleFromString(string $puzzleString): Puzzle
    {
        return static::parsePuzzle($puzzleString);
    }

    /**
     * @param string $puzzleFilePath
     *
     * @return Puzzle
     * @throws SudokuSolverException
     * @throws Exception
     */
    public static function parsePuzzleFromFile(string $puzzleFilePath): Puzzle
    {
        $filePath = static::getFilePath(Settings::getRootPathString() . $puzzleFilePath);
        $fileContent = static::getFileContentsFromFilePath($filePath);

        return static::parsePuzzle($fileContent->getFileContentString());
    }

    /**
     * @param string $puzzleFilePath
     *
     * @return Puzzle[]
     * @throws SudokuSolverException
     * @throws SudokuSolverExceptionFileSystem
     * @throws Exception
     */
    public static function parsePuzzleFromCsvFile(string $puzzleFilePath): array
    {
        $filePath = static::getFilePath(Settings::getRootPathString() . $puzzleFilePath);
        $fileContent = static::getFileContentsFromFilePath($filePath);

        return static::parsePuzzleFromCsvString($fileContent->getFileContentString());
    }

    /**
     * @param string $puzzleFilePath
     *
     * @return FilePath
     * @throws SudokuSolverException
     */
    private static function getFilePath(string $puzzleFilePath): FilePath
    {
        return new FilePath($puzzleFilePath);
    }

    /**
     * @param FilePath $filePath
     *
     * @return FileContent
     * @throws SudokuSolverException
     * @throws SudokuSolverExceptionFileSystem
     */
    private static function getFileContentsFromFilePath(FilePath $filePath): FileContent
    {
        if (static::doesFileExist($filePath)) {
            return static::getFileContents($filePath->getFilePathString());
        } else {
            throw new SudokuSolverExceptionPuzzleNotFound(
                vsprintf(self::ERROR_PUZZLE_NOT_FOUND, [$filePath->getFilePathString()])
            );
        }
    }

    /**
     * @param string $filePath
     *
     * @return FileContent
     * @throws SudokuSolverException
     * @throws SudokuSolverExceptionFileSystem
     */
    private static function getFileContents(string $filePath): FileContent
    {
        $fileData = file_get_contents($filePath);

        if ($fileData === false) {
            throw new SudokuSolverExceptionFileSystem(
                vsprintf(
                    self::ERROR_FAILED_FILE_GET_CONTENTS,
                    [$filePath]
                )
            );
        } else {
            return new FileContent($fileData);
        }
    }

    /**
     * @param FilePath $filePathPuzzle
     *
     * @return bool
     * @throws SudokuSolverExceptionPuzzleNotFound
     */
    private static function doesFileExist(FilePath $filePathPuzzle): bool
    {
        if (file_exists($filePathPuzzle->getFilePathString())) {
            return true;
        } else {
            throw new SudokuSolverExceptionPuzzleNotFound(
                vsprintf(self::ERROR_PUZZLE_NOT_FOUND, [$filePathPuzzle->getFilePathString()])
            );
        }
    }

    /**
     *
     * @param string $puzzleString
     *
     * @return Puzzle
     * @throws SudokuSolverExceptionParser
     */
    private static function parsePuzzle(string $puzzleString): Puzzle
    {
        // TODO: Extract.
        // Explode the file contents string by each line.
        $lines = explode(self::FILE_CONTENT_NEWLINE, $puzzleString);

        // Temporary array for each puzzle.
        $tempPuzzle = [];

        $lineCount = 0;
        // Iterate through each line.
        foreach ($lines as $line) {
            $lineCount++;

            // Remove leading and trailing white space.
            $trimmed = rtrim(ltrim($line));

            if (mb_substr($trimmed, 0, 1) != self::DELIMITER_HASH && $trimmed != self::DELIMITER_EMPTY) {
                // If the line is not a comment starting with #, add each comma separated value as an array entry.
                $row = explode(",", $trimmed);

                // Ensure each value is an integer.
                $sanitized_row = array_map("intval", array_filter($row, "is_numeric"));

                if (empty($sanitized_row)) {
                    throw new SudokuSolverExceptionParser(
                        vsprintf(self::ERROR_PUZZLE_ROW_INVALID, [$lineCount])
                    );
                } else {
                    // Add the row to the puzzle.
                    array_push($tempPuzzle, $sanitized_row);
                }
            } else {
                // Do nothing.
            }
        }

        return static::createPuzzleFromArrayInt($tempPuzzle);
    }

    /**
     * @param string $getFileContentString
     *
     * @return Puzzle[]
     * @throws SudokuSolverExceptionParser
     */
    private static function parsePuzzleFromCsvString(string $getFileContentString): array
    {
        $allPuzzles = [];
        $lineCount = 0;
        $lines = explode(self::FILE_CONTENT_NEWLINE, $getFileContentString);

        foreach ($lines as $line) {
            $lineCount++;
            $puzzleAndSolution = explode(self::DELIMITER_COMMA, $line);
            if (isset($puzzleAndSolution[0]) && isset($puzzleAndSolution[1])) {
                $puzzleString = static::getPuzzleString($puzzleAndSolution[0]);
                $puzzleSolutionString = static::getPuzzleSolutionString($puzzleAndSolution[1]);

                $puzzleStringWithNewlines = static::addPuzzleAllNewlineDelimiter($puzzleString);
                $puzzleSolutionStringWithNewlines = static::addPuzzleAllNewlineDelimiter($puzzleSolutionString);

                $puzzle = static::parsePuzzle($puzzleStringWithNewlines);
                $puzzleSolution = static::parsePuzzle($puzzleSolutionStringWithNewlines);

                if (static::isPuzzleSolutionValid($puzzleSolution, $lineCount)) {
                    $allPuzzles[] = $puzzle;
                    $allPuzzles[] = $puzzleSolution;
                } else {
                    // Puzzle solution is valid.
                }
            } else {
                // Reached end of file.
            }
        }

        return $allPuzzles;
    }

    /**
     * @param Puzzle $puzzleSolution
     *
     * @param int $lineCount
     *
     * @return bool
     * @throws SudokuSolverExceptionParser
     */
    private static function isPuzzleSolutionValid(Puzzle $puzzleSolution, int $lineCount)
    {
        if ($puzzleSolution->determineSolved()) {
            return true;
        } else {
            throw new SudokuSolverExceptionParser(
                vsprintf(self::ERROR_PUZZLE_SOLUTION_INVALID, [$lineCount, $puzzleSolution->toString()])
            );
        }
    }

    /**
     * @param string $puzzle
     *
     * @return string
     */
    private static function getPuzzleString(string $puzzle): string
    {
        $stringWithZeroes = str_replace(self::DELIMITER_PERIOD, self::DELIMITER_ZERO, $puzzle);
        $splitString = str_split($stringWithZeroes, self::SPLIT_LENGTH_ONE);

        return implode(self::DELIMITER_COMMA, $splitString);
    }

    /**
     * @param string $puzzleSolution
     *
     * @return string
     */
    private static function getPuzzleSolutionString(string $puzzleSolution): string
    {
        $splitString = str_split($puzzleSolution, self::SPLIT_LENGTH_ONE);

        return implode(self::DELIMITER_COMMA, $splitString);
    }

    /**
     * @param string $puzzle
     *
     * @return string
     */
    private static function addPuzzleAllNewlineDelimiter(string $puzzle): string
    {
        return implode(self::FILE_CONTENT_NEWLINE, str_split($puzzle, self::SPLIT_LENGTH_EIGTEEN));
    }

    /**
     * @param array $puzzleArray
     *
     * @return Puzzle
     * @throws SudokuSolverExceptionParser
     */
    private static function createPuzzleFromArrayInt(array $puzzleArray): Puzzle
    {
        $puzzle = new Puzzle($puzzleArray);

        static::assertPuzzleValid($puzzle);

        return $puzzle;
    }

    /**
     * @param Puzzle $puzzle
     *
     * @throws SudokuSolverExceptionParser
     */
    private static function assertPuzzleValid(Puzzle $puzzle)
    {
        static::assertArraySquare($puzzle);
        static::assertArrayAllClueValueValid($puzzle);
        static::assertArrayContainsMinimumNumberOfClue($puzzle);
        static::assertArrayAllClueValid($puzzle);
    }

    /**
     * @param Puzzle $puzzle
     *
     * @return bool
     * @throws SudokuSolverExceptionParser
     */
    private static function assertArraySquare(Puzzle $puzzle): bool
    {
        $puzzleArray = $puzzle->getPuzzleArray();
        $numberOfClues = count($puzzleArray, COUNT_RECURSIVE) - count($puzzleArray);

        if (sqrt($numberOfClues) != count($puzzleArray[0])) {
            throw new SudokuSolverExceptionParser(self::ERROR_PUZZLE_DIMENSIONS_INVALID);
        }

        return true;
    }

    /**
     * @param Puzzle $puzzle
     *
     * @return bool
     * @throws SudokuSolverExceptionParser
     */
    private static function assertArrayAllClueValueValid(Puzzle $puzzle): bool
    {
        $puzzleArray = $puzzle->getPuzzleArray();
        foreach ($puzzleArray as $row) {
            foreach ($row as $square) {
                if ($square < 0 || $square > 9) {
                    throw new SudokuSolverExceptionParser(
                        vsprintf(self::ERROR_PUZZLE_CAN_ONLY_CONTAIN_POSITIVE_NUMBERS, [$square])
                    );
                }
            }
        }

        return true;
    }

    /**
     * @param Puzzle $puzzle
     *
     * @return bool
     * @throws SudokuSolverExceptionParser
     */
    private static function assertArrayContainsMinimumNumberOfClue(Puzzle $puzzle): bool
    {
        $puzzleArray = $puzzle->getPuzzleArray();
        $clueCount = static::countNumberOfCluesInPuzzle($puzzleArray);

        if ($clueCount < self::PUZZLE_PARSER_MINIUM_NUMBER_OF_CLUES) {
            throw new SudokuSolverExceptionParser(
                vsprintf(
                    self::ERROR_PUZZLE_MINIMUM_NUMBER_OF_CLUES_INVALID,
                    [
                        $clueCount,
                        self::PUZZLE_PARSER_MINIUM_NUMBER_OF_CLUES
                    ]
                )
            );
        } else {
            return true;
        }
    }

    /**
     * @param Puzzle $puzzle
     *
     * @return bool
     * @throws SudokuSolverExceptionParser
     */
    private static function assertArrayAllClueValid(Puzzle $puzzle): bool
    {
        if (PuzzleLib::determineValid($puzzle)) {
            return true;
        } else {
            throw new SudokuSolverExceptionParser(self::ERROR_PUZZLE_INVALID);
        }
    }

    /**
     * @param array $arrayPuzzle
     *
     * @return int
     */
    private static function countNumberOfCluesInPuzzle(array $arrayPuzzle): int
    {
        $clueCount = 0;

        foreach ($arrayPuzzle as $row) {
            foreach ($row as $square) {
                if ($square !== 0) {
                    $clueCount++;
                }
            }
        }

        return $clueCount;
    }
}
