<?php
class Controller
{
    function __construct()
    {
        session_start();
        if (isset($_SESSION['id']))
            unset($_SESSION['id']);
        header('Location: /');
    }
}
new Controller();
