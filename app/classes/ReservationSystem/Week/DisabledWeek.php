<?php


namespace ReservationSystem\Week;


use ReservationSystem\Day\DisabledDay;
use ReservationSystem\Utils\Date;

class DisabledWeek extends Week
{

    public function __construct(int $weekNumber, int $yearNumber)
    {
        for ($i = 1; $i <= 7; $i++) {
            $this->days[] = new DisabledDay(Date::getDate($i, $weekNumber, $yearNumber), $i);
        }
    }

    public function getDaysArray() : Array
    {
        return $this->days;

    }



}