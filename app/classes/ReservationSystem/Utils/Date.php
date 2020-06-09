<?php


namespace ReservationSystem\Utils;


use mysql_xdevapi\Result;

class Date
{

    public static function getDate(int $day, int $week, int $year)
    {
        $dto = new \DateTime();
        $dto->setISODate($year, $week, $day);
        return $dto->format("d-m");
    }

}