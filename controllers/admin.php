<?php
class Controller
{
    function __construct()
    {
        session_start();
        if (!isset($_SESSION['id']) || $_SESSION['role'] !== 0) {
            header('Location: /controllers/login.php');
            exit();
        }
        require '../views/admin.php';
    }
}
new Controller();
