import Board from "./components/board/Board";
import History from "./components/historyBoard/History";

// import { useState } from "react";
import React from "react";
import "./App.css";

function App() {
  return (
    <div className="app">
      <h1>Sudoku Solver</h1>
      <div className="content">
        <div className="board">
          <Board />
        </div>
        <div className="history">
          <History />
        </div>
      </div>
    </div>
  );
}

export default App;
