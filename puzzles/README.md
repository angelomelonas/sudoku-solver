# Puzzle Parser

Puzzles are provided using an `m x n` grid of numbers, with columns separated by commas.
Empty cells are represented by zeros (`0`). Each row is delimited by a newline.
Spaces between numbers are ignored.

Puzzles should be placed in text files ending with the `.puzzle` extension. 
Consecutive puzzles in the same file should be separated by a newline.
All lines starting with a hash (`#`) will be ignored. These can be used for comments.

## Example Puzzle Format
Here is an example of how two Very Easy puzzles should be represented:

```
        # Very Easy Puzzle 1
        0, 0, 0, 1, 9, 0, 5, 8, 2
        5, 0, 8, 0, 2, 7, 0, 0, 9
        2, 9, 4, 8, 0, 0, 7, 0, 0
        0, 0, 6, 3, 7, 0, 0, 9, 4
        4, 3, 0, 0, 6, 2, 0, 5, 0
        9, 8, 0, 4, 0, 5, 6, 0, 0
        8, 0, 1, 0, 0, 0, 0, 2, 5
        0, 0, 9, 5, 8, 1, 4, 7, 0
        0, 7, 0, 2, 0, 9, 1, 6, 0
        
        # Very Easy Puzzle 2
        0, 0, 4, 0, 0, 0, 9, 7, 0 
        7, 0, 0, 8, 5, 0, 6, 0, 1
        5, 1, 0, 0, 6, 0, 0, 2, 0 
        0, 0, 0, 1, 0, 2, 0, 0, 0 
        0, 0, 0, 0, 0, 5, 0, 0, 0 
        0, 0, 0, 7, 0, 0, 0, 0, 0 
        6, 0, 7, 0, 0, 0, 2, 0, 0 
        4, 0, 0, 2, 0, 9, 0, 0, 8
        0, 0, 8, 4, 0, 0, 0, 9, 0 
```
