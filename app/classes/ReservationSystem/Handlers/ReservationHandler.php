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

        //Get year to display
        $reload = false;
        $currentYearNumber = date('Y');
        $yearNumber = $this->session->keyExists('yearNumber') ? $this->session->get('yearNumber') : $currentYearNumber;
        $yearNumber = intval($yearNumber);

        //Get week to display
        $currentWeekNumber = date('W');
        $weekNumber = $this->session->keyExists('weekNumber') ? $this->session->get('weekNumber') : $currentWeekNumber;
        $weekNumber = intval($weekNumber);

        //Navigate weeks/years if one of the buttons is pressed
        if (isset($_POST['previousWeekBtn'])) {
            $weekNumber--;
            if ($weekNumber == 0) {
                $weekNumber = 52;
                $yearNumber--;
            }
            $this->session->set('weekNumber', $weekNumber);
            $this->session->set('yearNumber', $yearNumber);
            header("Location:/");
            exit;
        }
        if (isset($_POST['nextWeekBtn'])) {
            $weekNumber++;
            if ($weekNumber == 52) {
                $weekNumber = 1;
                $yearNumber++;
            }
            $this->session->set('weekNumber', $weekNumber);
            $this->session->set('yearNumber', $yearNumber);
            header("Location:/");
            exit;
        }

        //Check week and year and adjust if necessary
        if ($yearNumber < MIN_YEAR || $yearNumber <= 0 || $yearNumber > MAX_YEAR) {
            $yearNumber = intval($currentYearNumber);
        }
        if ($weekNumber > 52 || $weekNumber <= 0) {
            $weekNumber = intval($currentWeekNumber);
        }

        //Set session keys
        $this->session->set('weekNumber', $weekNumber);
        $this->session->set('yearNumber', $yearNumber);

        //Set variables
        $displayedWeek = Week\Week::weekInit($this->db, $weekNumber, $yearNumber);
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
            'yearNumber' => $yearNumber,
            'dayBackground' => $dayBackground,
            'displayedWeek' => $displayedWeek
        ]);
    }
}