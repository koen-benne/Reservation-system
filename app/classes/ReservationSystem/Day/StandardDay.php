<?php


namespace ReservationSystem\Day;


class StandardDay extends Day
{

    public function __construct(int $day)
    {
        $this->day = $day;

        $this->blocks = [];

    }

}