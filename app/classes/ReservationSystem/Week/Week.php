<?php


namespace ReservationSystem\Week;


abstract class Week
{

    private $weekNumber;
    private $days;

    public static function weekInit(int $weekNumber)
    {

        if (Week::isOnSeasonWeek($weekNumber)) {
            return new EnabledWeek($weekNumber);
        } else {
            return new DisabledWeek();
        }
    }

    /**
     * @return bool
     */
    public static function isCurrentWeek() : bool
    {
        //Checks if the displayed week is also the current week
        if ($_GET["w"] == date('W')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param int $weekNumber
     * @return bool
     */
    public static function isOnSeasonWeek(int $weekNumber) : bool
    {
        //Return true if the given week is within the beach volleyball season
        if ($weekNumber > SEASON_START && $weekNumber < SEASON_END) {
            return true;
        } else {
            return false;
        }
    }

}