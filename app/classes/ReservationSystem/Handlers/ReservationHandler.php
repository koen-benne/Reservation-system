<?php

namespace ReservationSystem\Handlers;

use ReservationSystem\Week;
use ReservationSystem\Databases\Database;

class ReservationHandler extends BaseHandler
{

    /**
     * @var Database
     */
    private $db;

    /**
     * ReservationHandler constructor.
     * @param $templateName
     * @throws \ReflectionException
     */
    public function __construct($templateName)
    {
        parent::__construct($templateName);
        $this->db = (new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME))->getConnection();
    }

    protected function weekVieuw(): void
    {

        //Get week to display
        $currentWeekNumber = date('W');
        $weekNumber = $_GET["w"] ?? ($this->session->get('weekNumber') ?? 0);
        $weekNumber = intval($weekNumber);
        if ($weekNumber > 52 || $weekNumber <= 0) {
            header("Location: ?w=" . intval($currentWeekNumber));
            exit;
        }

        //Navigate weeks if one of the buttons is pressed
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
        $this->session->set('weekNumber', $weekNumber);

        //Set variables
        $displayedWeek = Week\Week::weekInit($weekNumber);
        $dayBackground = "";
        $hoursAmount = DAY_END - DAY_START;
        $isLoggedIn = false;
        if ($this->session->keyExists('user')) {
            $isLoggedIn = true;
        }

        //Create background for a day
        for($i = 1; $i <= $hoursAmount; $i++) {
            $dayBackground .= "
            <tr><td class='first'></td></tr>
            <tr><td class='second'></td></tr>
            ";
        }

        //Return formatted data
        $this->renderTemplate([
            'pageTitle' => 'Reserveren',
            "isLoggedIn" => $isLoggedIn,
            'hoursAmount' => $hoursAmount,
            'weekNumber' => $weekNumber,
            'dayBackground' => $dayBackground,
            'displayedWeek' => $displayedWeek
        ]);
    }
}