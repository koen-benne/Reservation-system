<?php


namespace ReservationSystem\Day;


use ReservationSystem\Block\ReservationBlock;
use ReservationSystem\Utils\Time;

class EnabledDay extends Day
{

    public function __construct(int $day)
    {
        $this->day = $day;

        $this->blocks[] = new ReservationBlock(new Time(8));

    }

}