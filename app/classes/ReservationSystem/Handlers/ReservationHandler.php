<?php

namespace ReservationSystem\Handlers;

use ReservationSystem\Utils\Time;
use ReservationSystem\Week;
use ReservationSystem\Databases\Database;

class ReservationHandler extends BaseHandler
{

    /**
     * @var Database
     */
    private $db;

    public function __construct($templateName)
    {
        parent::__construct($templateName);
        $this->db = (new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME))->getConnection();
    }

    protected function weekVieuw(): void
    {

        //Get week to display
        $currentWeekNumber = date('W');
        $weekNumber = $_GET["w"] ?? 0;
        $weekNumber = intval($weekNumber);
        if (isset($weekNumber) ? !($weekNumber <= 52 && $weekNumber > 0) : true) {
            header("Location: ?w=" . intval($currentWeekNumber));
            exit;
        }

        if (isset($_POST['previousWeekBtn'])) {
            $weekNumber--;
            header("Location: ?w=" . $weekNumber);
            exit;
        }

        if (isset($_POST['nextWeekBtn'])) {
            $weekNumber++;
            header("Location: ?w=" . $weekNumber);
            exit;
        }

        //Init the database
        $db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $db->getConnection();

        $displayedWeek = Week\Week::weekInit($weekNumber);
        $dayBackground = "";
        $hoursAmount = DAY_END - DAY_START;

        for($i = 1; $i <= $hoursAmount; $i++) {
            $dayBackground .= "
            <tr><td class='first'></td></tr>
            <tr><td class='second'></td></tr>
            ";
        }

        $db->closeConnection();

        //Return formatted data
        $this->renderTemplate([
            'pageTitle' => 'Reservation',
            'hoursAmount' => $hoursAmount,
            'weekNumber' => $weekNumber,
            'dayBackground' => $dayBackground,
            'displayedWeek' => $displayedWeek
        ]);
    }
}