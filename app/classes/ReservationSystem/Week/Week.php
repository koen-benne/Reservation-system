<?php


namespace ReservationSystem\Week;


use ReservationSystem\Databases\Database;

abstract class Week
{

    protected $db, $weekNumber, $yearNumber, $days, $id;


    /**
     * @param \PDO $db
     * @param int $weekNumber
     * @param int $yearNumber
     * @return DisabledWeek|EnabledWeek
     */
    public static function weekInit(\PDO $db, int $weekNumber, int $yearNumber)
    {
        if (Week::isOnSeasonWeek($weekNumber)) {
            return Week::getOnSeasonWeek($db, $weekNumber, $yearNumber);
        } else {
            return Week::getOffSeasonWeek($db, $weekNumber, $yearNumber);
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
        if ($weekNumber >= SEASON_START && $weekNumber <= SEASON_END) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param \PDO $db
     * @param int $weekNumber
     * @param int $yearNumber
     * @return DisabledWeek|EnabledWeek
     */
    public static function getOffSeasonWeek(\PDO $db, int $weekNumber, int $yearNumber)
    {
        $statement = $db->prepare("SELECT id, onseason FROM weeks WHERE week_number = :week_number and year = :year");
        $statement->execute([
            ':week_number' => $weekNumber,
            ':year' => $yearNumber
        ]);

        $result = $statement->fetch();
        if ($result['onseason'] === '1') {
            return new EnabledWeek($db, $result['id'], $weekNumber, $yearNumber);
        } else {
            return new DisabledWeek($weekNumber, $yearNumber);
        }
    }

    /**
     * @param \PDO $db
     * @param int $weekNumber
     * @param int $yearNumber
     * @return DisabledWeek|EnabledWeek
     */
    public static function getOnSeasonWeek(\PDO $db, int $weekNumber, int $yearNumber)
    {
        $statement = $db->prepare("SELECT id, onseason FROM weeks WHERE week_number = :weekNumber and year = :year");
        $statement->execute([
            ':weekNumber' => $weekNumber,
            ':year' => $yearNumber
        ]);
        $result = $statement->fetch();

        if ($result['onseason'] === '0') {
            return new DisabledWeek($weekNumber, $yearNumber);
        } else {
            return new EnabledWeek($db, $result['id'], $weekNumber, $yearNumber);
        }
    }

    public function getDaysArray(): array
    {
        return $this->days;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

}