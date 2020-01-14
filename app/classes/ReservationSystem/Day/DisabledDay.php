<?php


namespace ReservationSystem\Day;


class DisabledDay extends Day
{

    public function __construct(int $day)
    {
        $this->day = $day;

        $this->blocks = [];

    }

}