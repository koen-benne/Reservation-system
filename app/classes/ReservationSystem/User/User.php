<?php

namespace ReservationSystem\User;

class User
{
    public $id, $username, $email, $password;

    public static function add(\PDO $db, $user): bool
    {
        $statement = $db->prepare("INSERT INTO users (email, password, username) VALUES (:email, :password, :username)");
        return $statement->execute([
            ':email' => $user->email,
            ':password' => $user->password,
            ':username' => $user->username
        ]);
    }

    /**
     * @param \PDO $db
     * @param string $email
     * @return mixed
     * @throws \Exception
     */
    public static function getUser(\PDO $db, string $email)
    {
        $statement = $db->prepare("SELECT id, username, email, password FROM users WHERE email = :email");
        $statement->execute([
            ':email' => $email
        ]);

        if (($user = $statement->fetchObject("ReservationSystem\\User\\User")) === false) {
            throw new \Exception("User email is not available in the database");
        }

        return $user;

    }

    public function remove(\PDO $db)
    {
        $statement = $db->prepare("DELETE FROM users WHERE email = :email");
        $statement->execute([
            ':email' => $this->email
        ]);
    }

}