<?php


namespace ReservationSystem\Day;

abstract class Day
{
    protected $date;
    protected $blocks;
    protected $day;

    public function getDay(): int
    {
        return $this->day;
    }

    public function getBlocksArray(): array
    {
        return $this->blocks;
    }

    public function getDate(): string
    {
        return $this->date;
    }


}