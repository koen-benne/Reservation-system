<?php

namespace ReservationSystem\Block;

use ReservationSystem\Utils\Time;

abstract class Block
{

    protected $type;

    protected $start;

    protected $end;

    protected $lengthHours;

    protected $lengthMinutes;

    /**
     * @return Time
     */
    public function getStart(): Time
    {
        return $this->start;
    }

    /**
     * @return Time
     */
    public function getEnd(): Time
    {
        return $this->end;
    }

    public function getLength(): array
    {
        return ['hours' => $this->lengthHours, 'minutes' => $this->lengthMinutes];
    }

    public function isInside(Time $time) : boolean {
        if (($time->getHours() == $this->end->getHours() && $time->getMinutes() <= $this->end->getMinutes()) || $time->getHours() > $this->end->getHours()) {
            if (($time->getHours() == $this->start->getHours() && $time->getMinutes() >= $this->start) || $time->getHours() < $this->start->getHours()) {
                return true;
            }
        }

        return false;

    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getStyles($hoursAmount): string
    {
        return "top: " . (($this->getStart()->toHours() - DAY_START) / $hoursAmount) * 100 . "%;" .
            "height: " . (\ReservationSystem\Utils\Time::intsToHours($this->getLength()['hours'], $this->getLength()['minutes']) / $hoursAmount) * 100 . "%;";
    }

}