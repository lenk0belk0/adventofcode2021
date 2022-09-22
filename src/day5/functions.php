<?php
declare(strict_types=1);

function isLineHorizontal(array $line): bool {
    [$firstCoordinates,  $secondCoordinates] = $line;
    [, $firstY] = $firstCoordinates;
    [, $secondY] = $secondCoordinates;

    return $firstY === $secondY;
}

function isLineVertical(array $line): bool {
    [$firstCoordinates,  $secondCoordinates] = $line;
    [$firstX, ] = $firstCoordinates;
    [$secondX, ] = $secondCoordinates;

    return $firstX === $secondX;
}

function filterHorizontalOrVertical(array $lines): array {
    return array_filter($lines, static function(array $line) {
        return isLineHorizontal($line) || isLineVertical($line);
    });
}

function getVerticalLineCoverPoints(array $line): array
{
    [$firstCoordinates,  $secondCoordinates] = $line;
    [$x, $firstY] = $firstCoordinates;
    [, $secondY] = $secondCoordinates;
    $min = min($firstY, $secondY);
    $max = max($firstY, $secondY);

    return array_map(static function($y) use ($x) {
        return [$x, $y];
    }, range($min, $max));
}

function getHorizontalLineCoverPoints(array $line): array
{
    [$firstCoordinates,  $secondCoordinates] = $line;
    [$firstX, $y] = $firstCoordinates;
    [$secondX, ] = $secondCoordinates;
    $min = min($firstX, $secondX);
    $max = max($firstX, $secondX);

    return array_map(static function($x) use ($y) {
        return [$x, $y];
    }, range($min, $max));
}

function getLineCoverPoints(array $line): ?array {
    if (isLineVertical($line)) {
        return getVerticalLineCoverPoints($line);
    }
    if (isLineHorizontal($line)) {
        return getHorizontalLineCoverPoints($line);
    }
    return null;
}

function filterOverlapPoints(array $points, int $overlapLimit): array {
    $overlapMap = [];
    foreach ($points as $point) {
        [$pointX, $pointY] = $point;
        if(!isset($overlapMap[$pointX][$pointY])) {
            $overlapMap[$pointX][$pointY] = 0;
        }
        $overlapMap[$pointX][$pointY]++;
    }

    $result = [];
    foreach ($overlapMap as $x => $column) {
        foreach ($column as $y => $overlap) {
            if ($overlap >= $overlapLimit) {
                $result[] = [$x, $y];
            }
        }
    }

    return $result;
}

//echo sprintf("test check line is horizontal: %d\n", isLineVertical([[1, 2], [1, 3]]) === true);
//echo sprintf("test check line is not horizontal: %d\n", isLineHorizontal([[1, 2], [1, 3]]) === false);
//echo sprintf("test check line is vertical: %d\n", isLineHorizontal([[1, 2], [10, 2]]) === true);
//echo sprintf("test check line is not vertical: %d\n", isLineVertical([[1, 2], [10, 2]]) === false);
//echo sprintf("test check line is not vertical: %d\n", isLineVertical([[1, 3], [5, 6]]) === false);
//echo sprintf("test check line is not horizontal: %d\n", isLineHorizontal([[1, 3], [5, 6]]) === false);
//
//echo sprintf("test filter lines to leave only horizontal or vertical: %d\n", count(filterHorizontalOrVertical([[[1, 3], [5, 6]]])) === 0);
//echo sprintf("test filter lines to leave only horizontal or vertical: %d\n", count(filterHorizontalOrVertical([[[1, 2], [1, 3]]])) === 1);
//echo sprintf("test filter lines to leave only horizontal or vertical: %d\n", count(filterHorizontalOrVertical([[[1, 2], [10, 2]]])) === 1);
//
//echo sprintf("test get line cover points: %d\n", getLineCoverPoints([[1, 3], [1, 5]]) === [[1, 3], [1, 4], [1, 5]]);
//echo sprintf("test get line cover points: %d\n", getLineCoverPoints([[2, 2], [3, 2]]) === [[2, 2], [3, 2]]);
//echo sprintf("test get line cover points: %d\n", getLineCoverPoints([[1, 2], [1, 2]]) === [[1, 2]]);


