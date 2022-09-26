<?php
declare(strict_types=1);

include_once __DIR__ . '/../../vendor/autoload.php';

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

function getFishAmountForDay(array $fishList, int $days) {
    $fishForDayInCycle = [0, 0, 0, 0, 0, 0, 0, 0, 0];

    foreach ($fishList as $oneFish) {
        $fishForDayInCycle[$oneFish]++;
    }

    while ($days > 0) {
        $fishInZeroDayInCycle = array_shift($fishForDayInCycle);

        $fishForDayInCycle[8] = $fishInZeroDayInCycle; // add newborn to 8th day of cycle
        $fishForDayInCycle[6] += $fishInZeroDayInCycle; // move "mothers" to 6th day of cycle

        $days--;
    }

    return array_sum($fishForDayInCycle);
}

$exampleInput = [3,4,3,1,2];
var_dump(getFishAmountForDay($exampleInput, 256));

$input = parseInput(__DIR__ . '/input.txt');
var_dump(getFishAmountForDay($input, 256));

