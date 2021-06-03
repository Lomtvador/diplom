<?php
class Controller
{
    function __construct()
    {
        session_start();
        if (isset($_SESSION['id']))
            unset($_SESSION['id']);
        if (isset($_SESSION['role']))
            unset($_SESSION['role']);
        header('Location: /');
    }
}
new Controller();
