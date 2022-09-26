<?php
declare(strict_types=1);

include_once __DIR__ . '/../../vendor/autoload.php';

$fish = new \Lenk0belk0\Advenofcode2021\day6\Classes\Fish();
assert($fish->getInternalTimerValue() === 8, "test newborn fish has right internal timer value");

$anotherFish = new \Lenk0belk0\Advenofcode2021\day6\Classes\Fish(2);
assert($anotherFish->getInternalTimerValue() === 2, "test create fish with given internal timer value");

$anotherFish->liveOneDay();
assert($anotherFish->getInternalTimerValue() === 1, "test internal timer decreases when fish have lived one day");

$school = new \Lenk0belk0\Advenofcode2021\day6\Classes\School();
assert($school->getFish() === [], "test empty school");

$school->addOneFish($anotherFish);
assert($school->getFishTotal() === 1, "test can add fish to school");

$school->liveOneDay();
$school->liveOneDay();
$schoolFish = $school->getFish();

assert($school->getFishTotal() === 2, "test fish creates new fish");
assert($schoolFish[0]->getInternalTimerValue() === 6, "test fish has right internal timer");
assert($schoolFish[1]->getInternalTimerValue() === 8, "test fish has right internal timer");
