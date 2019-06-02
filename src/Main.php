<?php

declare(strict_types=1);

namespace AngeloMelonas\SudokuSolver;

class Main
{

    /**
     * Main constructor.
     */
    public function __construct()
    {
        echo "Main class";
        $parse = new \PuzzleParser("..\\puzzles\\basic.puzzle");
    }
}
