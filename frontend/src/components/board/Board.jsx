import React, { useState, useEffect } from "react";

const blankSudokuPuzzle = Array.from({ length: 9 }, () => Array(9).fill(""));

const Board = () => {
  return (
    <div className="board">
      {blankSudokuPuzzle.map((row, rowIndex) => (
        <div key={rowIndex} className="row">
          {row.map((cellValue, columnIndex) => (
            <input
              key={columnIndex}
              type="text"
              className="cell"
              value={cellValue}
              maxLength={1}
            />
          ))}
        </div>
      ))}
    </div>
  );
};

export default Board;
