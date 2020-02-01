# sudoku-solver
A simple Sudoku puzzle solver written in PHP.

:rotating_light: NOTE: This project is still under construction. :rotating_light:

## Installation
Run the following in the root of the projec to install sudoku-solver.

    composer install

## Terminology

    Row         Horizontal M cells
    Column      Vertical N cells
    Region      An m x n subset of cells
    Group       M/N number of cells in a row (horizontally or vertically) 

## Strategies for Solving Puzzles
The strategies used by this solver are based on the strategies as described by [Sudoku Dragon](http://www.sudokudragon.com/sudokustrategy.htm).

#### The Strategies
Strategies should be repeatedly applied until the puzzle is solved.

1. Only Choice Rule
   * Scan each row, column and region for a single choice in the group.
   
2. Single Possibility Rule
    * Scan each intersecting row and column for a single choice in the group.
    
3. Only Square Rule
    * Scan each row/column with two empty cells.
	* Identify the two missing numbers, A and B.
	* Scan each intersecting row, column or region and try to eliminate option A.
	* If option A can be eliminated for a particular cell, fill in option B in that cell.
	* Fill in option A in the other empty cell.
	
4. Two out of Three Rule
    * From the top down, scan three rows or columns at a time for a particular number starting at 1.

5. Sub-group exclusion rule
    * TODO

6. Brute Force
    * Try all options until a solution is found :)
