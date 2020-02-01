<?php

declare(strict_types=1);

namespace sudoku\solver\parser;

use sudoku\solver\common\exception\SudokuSolverException;
use sudoku\solver\common\exception\SudokuSolverExceptionFileSystem;
use sudoku\solver\common\exception\SudokuSolverExceptionPuzzleNotFound;
use sudoku\solver\common\object\FileContent;
use sudoku\solver\common\object\FilePath;
use sudoku\solver\common\object\Puzzle;
use sudoku\solver\common\util\Settings;
use sudoku\solver\parser\exception\SudokuSolverExceptionParser;
use Exception;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200201 Initial creation.
 */
class PuzzleParser
{
    /**
     * Error constants.
     */
    const ERROR_PUZZLE_NOT_FOUND = 'The puzzle was not found in "%s".';
    const ERROR_FAILED_FILE_GET_CONTENTS = 'Failed to get the contents of file "%s".';
    const ERROR_PUZZLE_CAN_ONLY_CONTAIN_POSITIVE_NUMBERS = '"%s" is an invalid cell value. The puzzle can only contain positive numbers.';
    const ERROR_PUZZLE_DIMENSIONS_INVALID = 'The puzzle dimensions have to be square.';
    const ERROR_PUZZLE_ROW_INVALID = 'Line %s in puzzle or file is not a valid row.';

    /**
     * File content constants.
     */
    const FILE_CONTENT_NEWLINE = "\n";

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

            if (mb_substr($trimmed, 0, 1) != "#" && $trimmed != "") {
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
     * @param int[][] $puzzle
     *
     * @return Puzzle
     * @throws SudokuSolverExceptionParser
     */
    private static function createPuzzleFromArrayInt(array $puzzle): Puzzle
    {
        static::assertPuzzleValid($puzzle);

        return new Puzzle($puzzle);
    }

    /**
     * @param int[][] $arrayPuzzle
     *
     * @throws SudokuSolverExceptionParser
     */
    private static function assertPuzzleValid(array $arrayPuzzle)
    {
        static::assertArraySquare($arrayPuzzle);
        static::assertArrayValuesValid($arrayPuzzle);
    }

    /**
     * @param array $arrayPuzzle
     *
     * @return bool
     * @throws SudokuSolverExceptionParser
     */
    private static function assertArraySquare(array $arrayPuzzle): bool
    {
        $numberOfValuesInRow = count($arrayPuzzle[0]);
        $numberOfValuesInPuzzle = count($arrayPuzzle, COUNT_RECURSIVE) - $numberOfValuesInRow;

        if (sqrt($numberOfValuesInPuzzle) != count($arrayPuzzle[0])) {
            throw new SudokuSolverExceptionParser(self::ERROR_PUZZLE_DIMENSIONS_INVALID);
        }

        return true;
    }

    /**
     * @param array $arrayPuzzle
     *
     * @return bool
     * @throws SudokuSolverExceptionParser
     */
    private static function assertArrayValuesValid(array $arrayPuzzle): bool
    {
        foreach ($arrayPuzzle as $row) {
            foreach ($row as $cell) {
                if ($cell < 0 || $cell > 9) {
                    throw new SudokuSolverExceptionParser(
                        vsprintf(self::ERROR_PUZZLE_CAN_ONLY_CONTAIN_POSITIVE_NUMBERS, [$cell])
                    );
                }
            }
        }

        return true;
    }
}
