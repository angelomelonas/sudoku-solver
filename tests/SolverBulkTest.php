<?php

namespace sudoku\solver\test;

use sudoku\solver\common\exception\SudokuSolverException;
use sudoku\solver\common\exception\SudokuSolverExceptionFileSystem;
use sudoku\solver\parser\Parser;
use sudoku\solver\puzzle\code\Puzzle;
use sudoku\solver\solver\Solver;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200205 Initial creation.
 */
class SolverBulkTest extends TestBase
{
    /**
     * Puzzle filepath constants.
     */
    const PATH_SIMPLE_PUZZLES = '/puzzles/simple.csv';
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
        $this->solveAllTests(Parser::parsePuzzleFromCsvFile(self::PATH_SIMPLE_PUZZLES));
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
        $this->solveAllTests(Parser::parsePuzzleFromCsvFile(self::PATH_INTERMEDIATE_PUZZLES));
    }

    /**
     * @throws SudokuSolverException
     * @throws SudokuSolverExceptionFileSystem
     */
    public function testAllPuzzleExpert()
    {
        $this->solveAllTests(Parser::parsePuzzleFromCsvFile(self::PATH_EXPERT_PUZZLES));
    }

    /**
     * @param array $allPuzzle
     */
    protected function solveAllTests(array $allPuzzle)
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
    protected function assertSolverOutput(
        Puzzle $puzzleInput,
        Puzzle $puzzleExpectedOutput,
        int $numberOfPuzzle,
        int $numberPuzzle
    ) {
        $this->printPuzzleProgress($puzzleInput, $numberPuzzle, $numberOfPuzzle);

        $solver = new Solver($puzzleInput);
        $solvedPuzzle = $solver->solvePuzzle();

        static::assertEquals($puzzleExpectedOutput->getPuzzleArray(), $solvedPuzzle->getPuzzleArray());
    }
}
