<?php

declare(strict_types=1);

namespace AngeloMelonas\SudokuSolver;

/**
 * Class PuzzleParser
 *
 * Returns an array of one or more m by n puzzles read from a given file.
 */
class PuzzleParser {

    private $puzzles;

    public function __construct($puzzleFilePath = "") {
        $this->puzzles = array();

        if ($puzzleFilePath != "") {
            $fileContents = $this->readFileContents($puzzleFilePath);
            $this->parseFileContents($fileContents);
        }
    }

    public function readFileContents(string $puzzleFilePath) {
        // Read and return the entire file contents.
        $fileContents = file_get_contents($puzzleFilePath);

        if (!$fileContents) {
            // Something went wrong reading the file.
            error_log("Failed to read the following file: " . $puzzleFilePath);
            exit();
        }

        return $fileContents;
    }

    public function parseFileContents(string $fileContents) {
        // Explode the file contents string by each line.
        $lines = explode("\n", $fileContents);

        // Temporary array for each puzzle.
        $tempPuzzle = array();

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
                    error_log("Line " . $lineCount . " in puzzle or file is not a valid row.");
                    exit();
                } else {
                    // Add the array to the puzzle.
                    array_push($tempPuzzle, $sanitized_row);
                }
            }

            // Puzzles are separated by newlines or by the end of the file.
            if ($trimmed == "" || $lineCount == count($lines)) {
                if ($tempPuzzle != null) {
                    // Add the current parsed puzzle to the list of puzzles.
                    $this->addPuzzle($tempPuzzle);
                    // Reset the temporary puzzle.
                    $tempPuzzle = array();
                }
            }
        }
    }

    private function addPuzzle(array $puzzle) {
        // First validate the puzzle.
        $this->validatePuzzle($puzzle);
        // If the puzzle is valid, add it to the list of puzzles.
        array_push($this->puzzles, $puzzle);
    }

    private function validatePuzzle(array $puzzle) {
        $cellCount = 0;

        foreach ($puzzle as $row) {
            foreach ($row as $cell) {
                if($cell < 0){
                    error_log("The puzzle can only contain positive numbers.");
                    exit();
                }
                $cellCount++;
            }
        }
        // Ensure the puzzle is square.
        if (sqrt($cellCount) != count($puzzle[0])) {
            error_log("The puzzle dimensions have to be square.");
            exit();
        }
    }

    /**
     * @return mixed
     */
    public function getAllPuzzles(): array {
        return $this->puzzles;
    }

    public function toString(array $puzzle) {
        echo "\n";
        foreach ($puzzle as $row) {
            foreach ($row as $cell) {
                echo $cell . " ";
            }
            echo "\n";
        }
    }
}
