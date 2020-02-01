<?php

namespace sudoku\solver\strategy;

interface Strategy
{
    public function applyStrategy(array $puzzle): array;
}
