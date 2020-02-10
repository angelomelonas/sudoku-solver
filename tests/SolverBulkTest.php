<?php

namespace sudoku\solver\test;

use PHPUnit\Framework\TestCase;
use sudoku\solver\common\exception\SudokuSolverException;
use sudoku\solver\common\exception\SudokuSolverExceptionFileSystem;
use sudoku\solver\parser\Parser;
use sudoku\solver\puzzle\code\Puzzle;
use sudoku\solver\solver\Solver;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200205 Initial creation.
 */
class SolverBulkTest extends TestCase
{
    /**
     * Puzzle filepath constants.
     */
    const PATH_EASY_PUZZLES = '/puzzles/easy.csv';
    const PATH_INTERMEDIATE_PUZZLES = '/puzzles/intermediate.csv';
    const PATH_EXPERT_PUZZLES = '/puzzles/expert.csv';

    /**
     * Testing print constants.
     */
    const PUZZLES_SOLVED = 'Solving %s/%s puzzles...' . "\n";

    /**
     * @throws SudokuSolverException
     * @throws SudokuSolverExceptionFileSystem
     */
    public function testAllPuzzleSimple()
    {
        $this->solveAllTests(Parser::parsePuzzleFromCsvFile(self::PATH_EASY_PUZZLES));
    }

    /**
     * @throws SudokuSolverException
     * @throws SudokuSolverExceptionFileSystem
     */
    public function testAllPuzzleEasy()
    {
        $this->solveAllTests(Parser::parsePuzzleFromCsvFile(self::PATH_EASY_PUZZLES));
    }

    /**
     * @throws SudokuSolverException
     * @throws SudokuSolverExceptionFileSystem
     */
    public function testAllPuzzleIntermediate()
    {
        $this->solveAllTests(Parser::parsePuzzleFromCsvFile(self::PATH_EASY_PUZZLES));
    }

    /**
     * @throws SudokuSolverException
     * @throws SudokuSolverExceptionFileSystem
     */
    public function testAllPuzzleExpert()
    {
        $this->solveAllTests(Parser::parsePuzzleFromCsvFile(self::PATH_EASY_PUZZLES));
    }

    /**
     * @param array $allPuzzle
     */
    private function solveAllTests(array $allPuzzle)
    {
        $numberOfPuzzle = count($allPuzzle) / 2;

        for ($puzzleIndex = 0; $puzzleIndex < count($allPuzzle); $puzzleIndex += 2) {
            $this->assertSolverOutput(
                $allPuzzle[$puzzleIndex],
                $allPuzzle[$puzzleIndex + 1],
                $numberOfPuzzle,
                $puzzleIndex
            );
        }
    }

    /**
     * @param Puzzle $puzzleInput
     * @param Puzzle $puzzleExpectedOutput
     * @param int $numberOfPuzzle
     * @param int $numberPuzzle
     */
    private function assertSolverOutput(
        Puzzle $puzzleInput,
        Puzzle $puzzleExpectedOutput,
        int $numberOfPuzzle,
        int $numberPuzzle
    ) {
        $solver = new Solver($puzzleInput);
        $solvedPuzzle = $solver->solvePuzzle();

        print_r(vsprintf(self::PUZZLES_SOLVED, [($numberPuzzle / 2) + 1, $numberOfPuzzle]));
        static::assertEquals($puzzleExpectedOutput->getPuzzleArray(), $solvedPuzzle->getPuzzleArray());
    }
}
