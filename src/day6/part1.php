<?php
declare(strict_types=1);

use Lenk0belk0\Advenofcode2021\day6\Classes\School;

include_once __DIR__ . '/../../vendor/autoload.php';

$exampleList = [3,4,3,1,2];

$days = 80;
$exampleSchool = School::initWithFishAgeList($exampleList);
$exampleSchool->liveSeveralDays($days);

echo sprintf("example total fish after $days days: %d\n", $exampleSchool->getFishTotal());

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

$input = parseInput(__DIR__ . '/input.txt');

$school = School::initWithFishAgeList($input);
$school->liveSeveralDays($days);

echo sprintf("total fish after $days days: %d\n", $school->getFishTotal());
