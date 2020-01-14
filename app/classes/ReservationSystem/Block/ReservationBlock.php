<?php

namespace ReservationSystem\Block;

use ReservationSystem\Utils\Time;

class ReservationBlock extends Block
{

    public function __construct(Time $start)
    {
        $this->type = "reservationBlock";

        $this->lengthHours = 1;
        $this->lengthMinutes = 0;

        $this->start = $start;

        $this->end = $this->start->add($this->lengthHours, $this->lengthMinutes);
    }

}