<?php

namespace Lenk0belk0\Advenofcode2021\day6\Classes;

class School
{
    /**
     * @var Fish[]
     */
    private $fish;

    public function __construct()
    {
        $this->fish = [];
    }

    public function addOneFish(Fish $fish): void
    {
        $fish->addToSchool($this);
        $this->fish[] = $fish;
    }

    public function liveOneDay(): void
    {
        foreach ($this->fish as $fish) {
            $fish->liveOneDay();
        }
    }

    public function liveSeveralDays(int $daysCount): void
    {
        while ($daysCount > 0) {
            $this->liveOneDay();
            $daysCount--;
        }
    }

    public function getFish(): array
    {
        return $this->fish;
    }

    public function getFishTotal(): int
    {
        return count($this->fish);
    }

    public static function initWithFishAgeList(array $list): self
    {
        $school = new self();
        foreach ($list as $number) {
            $school->addOneFish(new Fish($number));
        }

        return $school;
    }
}
