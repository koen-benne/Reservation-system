<?php


namespace ReservationSystem\Day;

abstract class Day
{
    protected $blocks;
    protected $day;

    public function getDay() : int
    {
        return $this->day;
    }

    public function getBlocksArray() : array
    {
        return $this->blocks;
    }


}