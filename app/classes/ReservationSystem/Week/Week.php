<?php


namespace ReservationSystem\Week;


use ReservationSystem\Databases\Database;

abstract class Week
{

    protected $db, $weekNumber, $yearNumber, $days;

    public static function weekInit(\PDO $db, int $weekNumber, int $yearNumber)
    {
        if (Week::isOnSeasonWeek($weekNumber)) {
             if (Week::isDisabledWeek($db, $weekNumber, $yearNumber)) {
                 return new DisabledWeek();
             } else {
                 return new EnabledWeek($db, $weekNumber, $yearNumber);
             }
        } else {
            if (Week::isEnabledWeek($db, $weekNumber, $yearNumber)) {
                return new EnabledWeek($db, $weekNumber, $yearNumber);
            } else {
                return new DisabledWeek();
            }
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

    /**
     * @param \PDO $db
     * @param int $weekNumber
     * @param int $yearNumber
     * @return bool
     */
    public static function isEnabledWeek(\PDO $db, int $weekNumber, int $yearNumber): bool
    {
        $statement = $db->prepare("SELECT onseason FROM weeks WHERE weeknumber = :weekNumber and year = :year");
        $statement->execute([
            ':weekNumber' => $weekNumber,
            ':year' => $yearNumber
        ]);
        $result = $statement->fetchColumn();
        if ($result == '1') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param \PDO $db
     * @param int $weekNumber
     * @param int $yearNumber
     * @return bool
     */
    public static function isDisabledWeek(\PDO $db, int $weekNumber, int $yearNumber): bool
    {
        $statement = $db->prepare("SELECT onseason FROM weeks WHERE weeknumber = :weekNumber and year = :year");
        $statement->execute([
            ':weekNumber' => $weekNumber,
            ':year' => $yearNumber
        ]);
        $result = $statement->fetchColumn();
        if ($result == '0') {
            return true;
        } else {
            return false;
        }
    }

}