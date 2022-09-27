<?php

function parseInput(string $pathToFile): array
{
    $result = [];

    $fo = fopen($pathToFile, 'rb');
    while ($buffer = fgets($fo, 4096)) {
        $numbers = explode(',', $buffer);
        foreach ($numbers as $number) {
            $result[] = (int)$number;
        }
    }
    fclose($fo);

    return $result;
}

function getPositionsGapWithPosition(array $positions, int $givenPosition): array {
    return array_map(static function($position) use ($givenPosition) {
        return abs($position - $givenPosition);
    }, $positions);
}

function getFuelForPosition(array $positions, int $givenPosition): int {
    return array_sum(getPositionsGapWithPosition($positions, $givenPosition));
}

function getFuelProgressiveForPosition(array $positions, int $givenPosition): int {
    $fuelForEachGap = array_map(static function($gap) {
        return $gap * (1 + $gap) / 2;
    }, getPositionsGapWithPosition($positions, $givenPosition));
    return array_sum($fuelForEachGap);
}

assert(getPositionsGapWithPosition([1, 2, 3], 2) === [1, 0, 1], 'assert can get right numbers gaps');
assert(getPositionsGapWithPosition([1, 2, 3], 3) === [2, 1, 0], 'assert can get right numbers gaps');

assert(getFuelForPosition([1, 2, 3], 2) === 2, 'assert can get right fuel amount');
assert(getFuelForPosition([1, 2, 3], 3) === 3, 'assert can get right fuel amount');

assert(getFuelProgressiveForPosition([1, 2, 3], 2) === 2, 'assert can get right fuel progressive amount 2');
assert(getFuelProgressiveForPosition([1, 2, 3], 3) === 4, 'assert can get right fuel progressive amount 4');


