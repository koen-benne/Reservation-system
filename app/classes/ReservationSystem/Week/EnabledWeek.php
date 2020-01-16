<?php


namespace ReservationSystem\Week;


use ReservationSystem\Day\Day;
use ReservationSystem\Day\DisabledDay;
use ReservationSystem\Day\EnabledDay;

class EnabledWeek
{

    public function __construct(\PDO $db, int $weekNumber)
    {
        $this->days = [
            1 => new EnabledDay(1),
            2 => new DisabledDay(2),
            3 => new EnabledDay(3),
            4 => new DisabledDay(4),
            5 => new EnabledDay(5),
            6 => new DisabledDay(6),
            7 => new EnabledDay(7)
        ];
    }

    public function getDaysArray(): Array
    {
        return $this->days;
    }

    public function getDay()
    {

    }

}