<?php
require_once "../../config/app.php";

class Auth
{
    public function __construct()
    {
        $this->connect_database = new Connect();
    }

    public function login($request)
    {
        $query = "SELECT * FROM users WHERE email='" . $request['email'] . "'";
        $user =  $this->connect_database->run_query($query);
        if ($user != null) {
            session_start();
            $_SESSION['start'] = 'start';
            header("Location: " .  $GLOBALS['baseurl']);
        } else {
            return "this email not found";
        }
    }

    public function logout()
    {
        unset($_SESSION['start']);
        session_destroy();
        return true;
    }
}
