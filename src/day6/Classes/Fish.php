<?php

namespace Lenk0belk0\Advenofcode2021\day6\Classes;

class Fish {

    public const DAYS_BEFORE_BORN_NEW_FISH = 7;

    /**
     * @var ?School
     */
    private $school;
    /**
     * @var int
     */
    private $internalTimerValue;

    public function __construct(?int $intervalTimerValue = null)
    {
        $this->internalTimerValue = $intervalTimerValue ?? self::DAYS_BEFORE_BORN_NEW_FISH + 1;
    }

    public function addToSchool(School $school): void
    {
        $this->school = $school;
    }

    public function getInternalTimerValue(): int
    {
        return $this->internalTimerValue;
    }

    public function liveOneDay(): void
    {
        if ($this->internalTimerValue === 0) {
            $this->school->addOneFish(new Fish());
            $this->internalTimerValue = self::DAYS_BEFORE_BORN_NEW_FISH - 1;
        } else {
            $this->internalTimerValue--;
        }
    }
}
