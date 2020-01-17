<?php


namespace ReservationSystem\Day;


class StandardDay extends Day
{

    public function __construct(int $day, string $date)
    {
        $this->day = $day;

        $this->blocks = [];

    }

}