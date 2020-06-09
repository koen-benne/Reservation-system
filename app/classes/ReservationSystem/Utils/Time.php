<?php


namespace ReservationSystem\Utils;


use mysql_xdevapi\Exception;

class Time
{

    /**
     * @var integer
     */
    private $hours;
    /**
     * @var integer
     */
    private $minutes;
    /**
     * @var integer
     */
    private $dayStartHour;
    /**
     * @var integer
     */
    private $dayEndHour;

    /**
     * Time constructor.
     * @param int $hours
     * @param int $minutes
     * @throws \Exception
     */
    public function __construct(int $hours, int $minutes = 0)
    {
        //Defining the start and end variables. If the constants seen below were not defined, 0 and 24 will be used.
        try {
            $this->dayStartHour = constant("DAY_START") < 0 ? 0 : constant("DAY_START");
            $this->dayEndHour = constant("DAY_END") > 24 ? 24 : constant("DAY_END");
        } catch (\Exception $e) {
            $this->dayStartHour = 0;
            $this->dayEndHour = 24;
        }

        if ($hours >= 24 || $hours < 0) {
            throw new \Exception("Object of class Time only takes values of hours from 0 up to 23");
        }
        if ($minutes >= 60 || $minutes < 0) {
            throw new \Exception("Object of class Time only takes values of minutes from 0 up to 59.");
        }

        if (isset($this->dayStartHour) && isset($this->dayEndHour)) {
            if ($hours < $this->dayStartHour || $hours >= $this->dayEndHour) {
                throw new \Exception("The value given to Time must be in between the \$DAY_START and \$DAY_END values.");
            }
        }

        $this->hours = $hours;
        $this->minutes = $minutes;
    }

    /**
     * @param int $hours
     * @param int $minutes
     * @return Time
     * @throws \Exception
     */
    public function add(int $hours, int $minutes = 0): Time
    {
        if ($hours < 0 || $minutes < 0) {
            throw new \Exception("When adding to or subtracting from time you can only add positive numbers");
        }

        $hours += $this->hours;
        $minutes += $this->minutes;

        while ($minutes >= 60) {
            $hours++;
            $minutes -= 60;
        }

        //Trunctuate values above dayEndHour, unless if dayEndHour is 24 in which case it will be reduced by one minute
        if (!($hours == $this->dayEndHour && $minutes == 0) && $hours > $this->dayEndHour) {
            $hours = $this->dayEndHour;
            $minutes = 0;
        }
        if ($hours == 24) {
            $hours = 23;
            $minutes = 59;
        }

        return new Time($hours, $minutes);

    }

    /**
     * @param int $hours
     * @param int $minutes
     * @return Time
     * @throws \Exception
     */
    public function subtract(int $hours, int $minutes = 0): Time
    {
        if ($hours < 0 || $minutes < 0) {
            throw new \Exception("When adding to or subtracting from time you can only add positive numbers");
        }

        $hours = $this->hours - $hours;
        $minutes = $this->minutes - $minutes;

        while ($minutes < 0) {
            $hours--;
            $minutes += 60;
        }

        if ($hours <= $this->dayStartHour) {
            $hours = $this->dayStartHour;
            $minutes = 0;
        }

        return new Time($hours, $minutes);

    }

    /**
     * @return int
     */
    public function getHours(): int
    {
        return $this->hours;
    }

    /**
     * @return int
     */
    public function getMinutes(): int
    {
        return $this->minutes;
    }

    public function getString(): string
    {
        if (strlen(strval($this->minutes)) < 2) {
            $minutes = "0" . $this->minutes;
        } else {
            $minutes = $this->minutes;
        }

        return $this->hours . ":" . $minutes;
    }

    public function toHours(): float
    {
        return $this->hours + $this->minutes / 60;
    }

    public static function intsToHours(int $hours, int $minutes): float
    {
        return $hours + $minutes / 60;
    }

    public static function stringToTime(string $time): Time
    {
        $time = explode(":", $time);
        return new Time($time[0], $time[1]);
    }

}