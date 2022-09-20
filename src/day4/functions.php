<?php
declare(strict_types=1);

// TODO think about bit masks
CONST MARKED_BOARD_CELL = 1;
CONST UNMARKED_BOARD_CELL = 0;

function findNumberInBoardRow(array $row, int $number): ?int {
    foreach ($row as $columnIndex => $numberInRow) {
        if ($number === $numberInRow) {
            return $columnIndex;
        }
    }

    return null;
}

function findNumberInBoard(array $board, int $number): ?array {
    foreach ($board as $rowIndex => $row) {
        $columnIndex = findNumberInBoardRow($row, $number);
        if ($columnIndex !== null) {
            return [$rowIndex, $columnIndex];
        }
    }

    return null;
}

function getEmptyBoard(array $board): array {
    $result = [];
    foreach ($board as $rowIndex => $row) {
        foreach ($row as $columnIndex => $value) {
            $result[$rowIndex][$columnIndex] = UNMARKED_BOARD_CELL;
        }
    }

    return $result;
}

function getEmptyBoards(array $boards): array {
    $emptyBoards = [];
    foreach ($boards as $board) {
        $emptyBoards[] = getEmptyBoard($board);
    }

    return $emptyBoards;
}

function markNumberInBoard(array $board, $rowIndex, $columnIndex): array
{
    $board[$rowIndex][$columnIndex] = MARKED_BOARD_CELL;
    return $board;
}

function isRowInBoardMarked(array $board, int $rowIndex): bool {
    $rowNumbers = $board[$rowIndex];
    foreach ($rowNumbers as $number) {
        if ($number === UNMARKED_BOARD_CELL) {
            return false;
        }
    }

    return true;
}

function isColumnInBoardMarked(array $board, $columnIndex): bool
{
    $columnNumbers = array_column($board, $columnIndex);
    foreach ($columnNumbers as $number) {
        if ($number === UNMARKED_BOARD_CELL) {
            return false;
        }
    }
    return true;
}

function playBingoWithOneBoard(array $board, array &$markedBoard, $number): bool
{
    $rowColumnIndexList = findNumberInBoard($board, $number);
    if ($rowColumnIndexList !== null) {
        [$rowIndex, $columnIndex] = $rowColumnIndexList;
        $markedBoard = markNumberInBoard($markedBoard, $rowIndex, $columnIndex);
        $isRowWon = isRowInBoardMarked($markedBoard, $rowIndex);
        $isColumnWon = isColumnInBoardMarked($markedBoard, $columnIndex);

        return $isRowWon || $isColumnWon;
    }

    return false;
}

function playBingoWithSeveralBoards(array $boards, array &$markedBoards, int $number): ?array {
    $winnerIndexList = [];
    foreach ($boards as $index => $board) {
        $isBoardWinner = playBingoWithOneBoard($board, $markedBoards[$index], $number);
        if ($isBoardWinner) {
            $winnerIndexList[] = $index;
        }
    }

    return !empty($winnerIndexList) ? $winnerIndexList : null;
}

function calculateScore($board, $markedBoard, $number): int {
    $result = 0;
    foreach ($board as $rowIndex => $row) {
        foreach ($row as $columnIndex => $value) {
            if($markedBoard[$rowIndex][$columnIndex] === UNMARKED_BOARD_CELL) {
                $result += $value;
            }
        }
    }

    return $result * $number;
}

//$testBoard = [[1, 2, 3], [6, 8, 4], [10, 5, 7]];
//echo sprintf("test returns right position for number: %d\n", findNumberInBoardRow($testBoard[2], 10) === 0);
//echo sprintf("test return null if there is no number in row: %d\n", findNumberInBoardRow($testBoard[2], 1) === null);
//echo sprintf("test returns right positions for number in board: %d\n", findNumberInBoard($testBoard, 10) === [2, 0]);
//echo sprintf("test can get empty board: %d\n", getEmptyBoard($testBoard) === [[0, 0, 0], [0, 0, 0], [0, 0, 0]]);
//echo sprintf("test can mark number in board: %d\n", markNumberInBoard(getEmptyBoard($testBoard), 1, 1) === [[0, 0, 0], [0, 1, 0], [0, 0, 0]]);
//echo sprintf("test can check marked row: %d\n", isRowInBoardMarked([[1, 1, 1]], 0) === true);
//echo sprintf("test can check marked row: %d\n", isRowInBoardMarked([[0, 1, 1]], 0) === false);
//echo sprintf("test can check marked row: %d\n", isRowInBoardMarked([[1, 1, 0]], 0) === false);
//echo sprintf("test can check marked column: %d\n", isColumnInBoardMarked([[1, 1, 0], [1, 0, 0], [1, 1, 0]], 0) === true);
//echo sprintf("test can check marked column: %d\n", isColumnInBoardMarked([[1, 1, 0], [1, 0, 0], [1, 1, 0]], 1) === false);
//
//$emptyTestBoard = getEmptyBoard($testBoard);
//echo sprintf("test can play one board round %d\n", playBingoWithOneBoard($testBoard, $emptyTestBoard, 1) === false);
