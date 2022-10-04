<?php
declare(strict_types=1);

function parseInput(string $pathToFile): array
{
    $result = [];

    $fo = fopen($pathToFile, 'rb');
    while ($buffer = fgets($fo, 4096)) {
        $result[] = $buffer;
    }
    fclose($fo);

    return $result;
}

function getDigitToSegmentsMap(): array {
    return [
        0 => [
            'a' => true,
            'b' => true,
            'c' => true,
            'd' => false,
            'e' => true,
            'f' => true,
            'g' => true,
        ],
        1 => [
            'a' => false,
            'b' => false,
            'c' => true,
            'd' => false,
            'e' => false,
            'f' => true,
            'g' => false,
        ],
        2 => [
            'a' => true,
            'b' => false,
            'c' => true,
            'd' => true,
            'e' => true,
            'f' => false,
            'g' => true,
        ],
        3 => [
            'a' => true,
            'b' => false,
            'c' => true,
            'd' => true,
            'e' => false,
            'f' => true,
            'g' => true,
        ],
        4 => [
            'a' => false,
            'b' => true,
            'c' => true,
            'd' => true,
            'e' => false,
            'f' => true,
            'g' => false,
        ],
        5 => [
            'a' => true,
            'b' => true,
            'c' => false,
            'd' => true,
            'e' => false,
            'f' => true,
            'g' => true,
        ],
        6 => [
            'a' => true,
            'b' => true,
            'c' => false,
            'd' => true,
            'e' => true,
            'f' => true,
            'g' => true,
        ],
        7 => [
            'a' => true,
            'b' => false,
            'c' => true,
            'd' => false,
            'e' => false,
            'f' => true,
            'g' => false,
        ],
        8 => [
            'a' => true,
            'b' => true,
            'c' => true,
            'd' => true,
            'e' => true,
            'f' => true,
            'g' => true,
        ],
        9 => [
            'a' => true,
            'b' => true,
            'c' => true,
            'd' => true,
            'e' => false,
            'f' => true,
            'g' => true,
        ],
    ];
}

function getDigitToSegmentsCountMap(): array {
    return array_map(static function(array $segments) {
        return count(array_filter($segments));
    }, getDigitToSegmentsMap());
}

function mapDigitToSegments(int $digit): ?array
{
    return getDigitToSegmentsMap()[$digit] ?? null;
}

function mapDigitToSegmentsCount(int $digit): ?int
{
    return getDigitToSegmentsCountMap()[$digit] ?? null;
}

function mapSegmentsCountToDigits(int $givenCount): array {
   return array_keys(array_filter(getDigitToSegmentsCountMap(), static function($count) use ($givenCount) {
       return $count === $givenCount;
    }));
}

function getSegmentsFromDigitString(string $string): array
{
    return str_split($string);
}

function getUniqueSignalPatterns(string $line): array {
    $parts = explode('|', $line);
    return explode(' ', trim($parts[0]));
}

function getFourDigitsOutputValue(string $line): array {
    $parts = explode('|', $line);
    return explode(' ', trim($parts[1]));
}

assert(array_filter(mapDigitToSegments(1)) === ['c' => true, 'f' => true], 'assert can get right segments for 1');
assert(array_filter(mapDigitToSegments(5)) === ['a' => true, 'b' => true, 'd' => true, 'f' => true, 'g' => true], 'assert can get right segments for 5');
assert(mapDigitToSegments(123) === null, 'assert get null for unknown number');

assert(mapDigitToSegmentsCount(0) === 6, 'assert can get right segments count for 0');
assert(mapDigitToSegmentsCount(7) === 3, 'assert can get right segments count for 7');
assert(mapDigitToSegmentsCount(8) === 7, 'assert can get right segments count for 8');

assert(mapSegmentsCountToDigits(2) === [1], 'assert can get match digits for segments count 2');
assert(mapSegmentsCountToDigits(3) === [7], 'assert can get match digits for segments count 3');
assert(mapSegmentsCountToDigits(7) === [8], 'assert can get match digits for segments count 7');
assert(mapSegmentsCountToDigits(5) === [2, 3, 5], 'assert can get match digits for segments count 5');

assert(getSegmentsFromDigitString('cf') === ['c', 'f'], 'assert can map string to segments array');

assert(getUniqueSignalPatterns('qwe asdf qweqwe asd qwerqwer adsad | qw sfasd qwe') === ['qwe', 'asdf', 'qweqwe', 'asd', 'qwerqwer', 'adsad']);
assert(getFourDigitsOutputValue('qwe asdf qweqwe asd qwerqwer adsad | qw sfasd qwe') === ['qw', 'sfasd', 'qwe']);
