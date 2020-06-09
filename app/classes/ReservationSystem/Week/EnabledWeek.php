<?php


namespace ReservationSystem\Week;


use ReservationSystem\Day\Day;
use ReservationSystem\Day\DisabledDay;
use ReservationSystem\Day\EnabledDay;
use ReservationSystem\Day\StandardDay;
use ReservationSystem\Utils\Date;

class EnabledWeek extends Week
{

    public function __construct(\PDO $db, $id, int $weekNumber, int $yearNumber)
    {

        $this->id = $id;

        for ($i = 1; $i <= 7; $i++) {
            $this->days[] = EnabledWeek::getDay($db, $id, $weekNumber, $i, $yearNumber);
        }
    }


    /**
     * @param \PDO $db
     * @param int $id
     * @param int $weekNumber
     * @param int $dayNumber
     * @param int $yearNumber
     * @return mixed
     */
    public static function getDay(\PDO $db, $id, int $weekNumber, int $dayNumber, int $yearNumber)
    {
        $statement = $db->prepare(
            "SELECT enabled, id FROM days WHERE weeks_id = :weeks_id AND day_number = :day_number;");
        $statement->execute([
            ':day_number' =>$dayNumber,
            ':weeks_id' => $id
        ]);

        $result = $statement->fetch();

        $date = Date::getDate($dayNumber, $weekNumber, $yearNumber);

        if ($result["enabled"] === '1') {
            return new EnabledDay($result['id'], $dayNumber, $date, $db);
        } else if ($result["enabled"] === '0') {
            return new DisabledDay($date, $dayNumber);
        } else {
            return new StandardDay($date, $dayNumber);
        }
    }

}