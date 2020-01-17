<?php


namespace ReservationSystem\Week;


use ReservationSystem\Day\Day;
use ReservationSystem\Day\DisabledDay;
use ReservationSystem\Day\EnabledDay;
use ReservationSystem\Day\StandardDay;

class EnabledWeek extends Week
{

    public function __construct(\PDO $db, int $weekNumber, int $yearNumber)
    {

        for ($i = 1; $i <= 7; $i++) {
            $this->days[] = EnabledWeek::initDay($db, $weekNumber, $i, $yearNumber);
        }
    }

    public function getDaysArray(): array
    {
        return $this->days;
    }

    public function getDay()
    {

    }

    /**
     * @param \PDO $db
     * @param int $weekNumber
     * @param int $dayNumber
     * @param int $yearNumber
     * @return EnabledDay
     * @return DisabledDay
     */
    public static function initDay(\PDO $db, int $weekNumber, int $dayNumber, int $yearNumber)
    {
        $statement = $db->prepare(
            "SELECT enabled, date FROM days WHERE weeknumber = :weekNumber and dayNumber = :dayNumber and date BETWEEN :firstDate AND :lastDate;");
        $statement->execute([
            ':weekNumber' => $weekNumber,
            ':dayNumber' => $dayNumber,
            ':firstDate' => $yearNumber . "-01-01",
            ':lastDate' => $yearNumber . "-12-30"
        ]);

        $result = $statement->fetch();

        if ($result["enabled"] === '1') {
            return new EnabledDay($dayNumber, $result["date"]);
        } else if ($result["enabled"] === '0') {
            return new DisabledDay($dayNumber, $result["date"]);
        }

        var_dump($result);
        return new StandardDay($dayNumber, $result["date"]);
    }

}