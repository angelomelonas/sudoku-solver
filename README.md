# sudoku-solver
A simple Sudoku puzzle solver written in PHP.

:rotating_light: NOTE: This project is still under construction. :rotating_light:

## Installation
Run the following in the root of the projec to install sudoku-solver.

    composer install

## Terminology
    
    Square      One of the m x n values on the puzzle board
    Row         Horizontal M squares
    Column      Vertical N squares
    Region      An m x n subset of squares
    Group       M/N number of squares in a row (horizontally or vertically) 

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

### Resources
* https://www.educative.io/edpresso/how-to-check-if-a-sudoku-board-is-valid
* https://puzzling.stackexchange.com/questions/158/how-many-minimal-clue-sudoku-puzzles-are-there
* https://www.technologyreview.com/s/426554/mathematicians-solve-minimum-sudoku-problem/
