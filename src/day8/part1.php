<?php
declare(strict_types=1);

include_once __DIR__ . '/functions.php';

$exampleLines = [
    'be cfbegad cbdgef fgaecd cgeb fdcge agebfd fecdb fabcd edb | fdgacbe cefdb cefbgd gcbe',
    'edbfga begcd cbg gc gcadebf fbgde acbgfd abcde gfcbed gfec | fcgedb cgb dgebacf gc',
    'fgaebd cg bdaec gdafb agbcfd gdcbef bgcad gfac gcb cdgabef | cg cg fdcagb cbg',
    'fbegcd cbd adcefb dageb afcb bc aefdc ecdab fgdeca fcdbega | efabcd cedba gadfec cb',
    'aecbfdg fbg gf bafeg dbefa fcge gcbea fcaegb dgceab fcbdga | gecf egdcabf bgf bfgea',
    'fgeab ca afcebg bdacfeg cfaedg gcfdb baec bfadeg bafgc acf | gebdcfa ecba ca fadegcb',
    'dbcfg fgd bdegcaf fgec aegbdf ecdfab fbedc dacgb gdcebf gf | cefg dcbef fcge gbcadfe',
    'bdfegc cbegaf gecbf dfcage bdacg ed bedf ced adcbefg gebcd | ed bcgafe cdgba cbgef',
    'egadfb cdbfeg cegd fecab cgb gbdefca cg fgcdab egfdb bfceg | gbdfcae bgc cg cgb',
    'gcafb gcf dcaebfg ecagb gf abcdeg gaef cafbge fdbac fegbdc | fgae cfgab fg bagce',
];

function getCountOfSimpleDigitsInOutputInLines(array $lines): int {
    $result = 0;

    foreach ($lines as $line) {
        $result += getCountOfSimpleDigitsInOutputInLine($line);
    }

    return $result;
}

function getCountOfSimpleDigitsInOutputInLine(string $line): int {
    $result = 0;

    foreach (getFourDigitsOutputValue($line) as $digit) {
        $matchDigits = mapSegmentsCountToDigits(count(getSegmentsFromDigitString($digit)));
        if (count($matchDigits) === 1) {
            $result++;
        }
    }

    return $result;
}

assert(getCountOfSimpleDigitsInOutputInLines($exampleLines) === 26);

$input = parseInput(__DIR__ . '/input.txt');
var_dump(getCountOfSimpleDigitsInOutputInLines($input));
