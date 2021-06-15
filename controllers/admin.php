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
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/admin.php';
    }
}
new Controller();
