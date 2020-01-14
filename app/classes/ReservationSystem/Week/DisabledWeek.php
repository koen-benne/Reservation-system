<?php


namespace ReservationSystem\Week;


use ReservationSystem\Day\DisabledDay;

class DisabledWeek extends Week
{

    private $days = [];

    public function __construct()
    {
        $this->days = [
        1 => new DisabledDay(1),
        2 => new DisabledDay(2),
        3 => new DisabledDay(3),
        4 => new DisabledDay(4),
        5 => new DisabledDay(5),
        6 => new DisabledDay(6),
        7 => new DisabledDay(7)
        ];
    }

    public function getDaysArray() : Array
    {
        return $this->days;

    }



}