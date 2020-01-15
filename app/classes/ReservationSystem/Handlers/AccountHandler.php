<?php


namespace ReservationSystem\Handlers;


use ReservationSystem\Databases\Database;

class AccountHandler extends BaseHandler
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

    protected function login(): void
    {
        //If already logged in, no need to be here
        if ($this->session->keyExists('user')) {
            header('Location: add');
            exit;
        }

        //Return formatted data
        $this->renderTemplate([
            'pageTitle' => 'Log In'
        ]);
    }

}