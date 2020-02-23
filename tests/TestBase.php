<?php
namespace sudoku\solver\test;

use PHPUnit\Framework\TestCase;
use sudoku\solver\puzzle\code\Puzzle;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200216 Initial creation.
 */
abstract class TestBase extends TestCase
{
    /**
     * Testing print constants.
     */
    const PUZZLES_SOLVED = 'Solving %s/%s puzzles...' . "\n";

    /**
     * @param Puzzle $puzzleInput
     * @param Puzzle $puzzleExpectedOutput
     * @param int $numberOfPuzzle
     * @param int $numberPuzzle
     */
    abstract protected function assertSolverOutput(
        Puzzle $puzzleInput,
        Puzzle $puzzleExpectedOutput,
        int $numberOfPuzzle,
        int $numberPuzzle
    );

    /**
     * @param Puzzle $puzzle
     * @param int $numberPuzzle
     * @param int $numberOfPuzzle
     */
    protected function printPuzzleProgress(Puzzle $puzzle, int $numberPuzzle, int $numberOfPuzzle)
    {
        fwrite(STDERR, print_r(vsprintf(self::PUZZLES_SOLVED, [($numberPuzzle / 2) + 1, $numberOfPuzzle]), true));
        fwrite(STDERR, print_r($puzzle->toString(), true));
    }
}
