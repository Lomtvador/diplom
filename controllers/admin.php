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
        $admin = file_get_contents('../views/admin.html');
        $navigation = file_get_contents('../views/navigation.html');
        $adminNavigation = file_get_contents('../views/adminNavigation.html');
        $styles = '<link rel="stylesheet" href="/views/index.css">';
        $admin = sprintf($admin, $styles, $navigation, $adminNavigation);
        echo $admin;
    }
}
new Controller();
