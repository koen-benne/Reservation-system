<?php


namespace ReservationSystem\Handlers;


use ReservationSystem\Databases\Database;
use ReservationSystem\Form\Validation\LoginValidator;
use ReservationSystem\Form\Validation\SigninValidator;
use ReservationSystem\User\User;
use ReservationSystem\Form\Data;

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

        if (isset($_POST['submit'])) {
            //Set form data
            $formData = new Data($_POST);

            //Set post variables
            $email = $formData->getPostVar('email');
            $password = $formData->getPostVar('password');

            //Get the record from the db
            try {
                $user = User::getUser($this->db, $email);
            } catch (\Exception $e) {
                $user = new User();
            }

            //Actual validation
            $validator = new LoginValidator($user, $password);
            $validator->validate($this->db);
            $this->errors = $validator->getErrors();
        }

        //When no error, set session variable, redirect & exit script
        if (isset($user) && empty($this->errors)) {
            $this->session->set('user', $user);
            header('Location: /');
            exit;
        }

        //Return formatted data
        $this->renderTemplate([
            'pageTitle' => 'Log In',
            'email' => $email ?? '',
            'errors' => $this->errors,
            'style' => 'loginStyles'
        ]);
    }

    protected function signin()
    {
        //If already logged in, no need to be here
        if ($this->session->keyExists('user')) {
            header('Location: add');
            exit;
        }

        if (isset($_POST['submit'])) {
            //Set form data
            $formData = new Data($_POST);

            //Set post variables
            $username = $formData->getPostVar('username');
            $email = $formData->getPostVar('email');
            $password = $formData->getPostVar('password');

            //Actual validation
            $validator = new SigninValidator($username, $email, $password);
            $validator->validate($this->db);
            $this->errors = $validator->getErrors();

            //When no error, set session variable, redirect & exit script
            if (empty($this->errors)) {
                $user = new User();
                $user->email = $email;
                $user->password = password_hash($password, PASSWORD_ARGON2I);
                $user->username = $username;
                User::add($this->db, $user);
                $user = User::getUser($this->db, $email);
                $this->session->set('user', $user);
                header('Location: /');
                exit;
            }
        }


        //Return formatted data
        $this->renderTemplate([
            'pageTitle' => 'Sign In',
            'username' => $username ?? '',
            'email' => $email ?? '',
            'errors' => $this->errors
        ]);
    }

    protected function logout()
    {
        $this->session->delete('user');
        header("Location: /");
        exit;
    }

    protected function user()
    {
        //If not logged in, no need to be here
        if (!$this->session->keyExists('user')) {
            header('Location: add');
            exit;
        }

        $user = $this->session->get('user');

        if (isset($_POST['remove'])) {
            $user->remove($this->db);
            header('Location: logout');
            exit;
        }

        //Return formatted data
        $this->renderTemplate([
            'pageTitle' => 'User',
            'style' => 'userStyles',
            'username' => $user->username ?? '',
            'email' => $user->email ?? '',
        ]);
    }

}