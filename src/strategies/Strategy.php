<?php

declare(strict_types=1);

namespace AngeloMelonas\SudokuSolver\Strategies;

interface Strategy
{

    public function applyStrategy(array $puzzle): array;
}
