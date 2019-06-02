<?php

class Solver
{

    private $puzzle;
    private $isSolved = false;

    public function __construct($puzzle = null)
    {
        if ($puzzle) {
            $this->puzzle = $puzzle;
        }
    }

    public function solve(array $puzzle)
    {
        $oneChoiceOnlyStrategy = new OneChoiceOnly();

        $currentPuzzle = $puzzle;

        while (!$this->isSolved) {
            // Try to solve the puzzle.
            $puzzleAfterStrategy = $this->applyStrategy($oneChoiceOnlyStrategy, $currentPuzzle);

            if ($puzzleAfterStrategy == $currentPuzzle) {
                // Nothing changed after applying the strategy. Time to try something else...
                // TODO
            }
        }
    }

    public function applyStrategy(Strategy $strategy, array $puzzle): array
    {
        return $strategy->applyStrategy($puzzle);
    }
}
