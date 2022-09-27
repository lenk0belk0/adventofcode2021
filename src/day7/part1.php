<?php
declare(strict_types=1);

include_once (__DIR__ . '/functions.php');

$exampleInput = [16,1,2,0,4,2,7,1,2,14];
$input = parseInput(__DIR__ . '/input.txt');

function getMinFuelNeedToAlignNumber(array $numbers): int
{
    asort($numbers);
    $numbers = array_values($numbers);

    $min = $numbers[0];
    $max = $numbers[count($numbers) - 1];

    $fuel = getFuelForPosition($numbers, $min);
    foreach (range($min + 1, $max) as $number) {
        $nextFuel = getFuelForPosition($numbers, $number);
        if ($nextFuel <= $fuel) {
            $fuel = $nextFuel;
        } else {
            break;
        }

    }

    return $fuel;
}

assert(getMinFuelNeedToAlignNumber($exampleInput) === 37, 'assert function return right value for example');

var_dump(getMinFuelNeedToAlignNumber($input));
