<?php
require '../models/productInfo.php';
class Controller
{
    private Model $model;
    function __construct()
    {
        if (!isset($_GET['id'])) {
            header('Location: /');
            exit();
        }
        $id = intval($_GET['id']);
        session_start();
        $admin = false;
        if (isset($_SESSION['id']) && $_SESSION['role'] === 0) {
            $admin = true;
        }
        $this->model = new Model($id, $admin);
        $p = $this->model;
        require '../views/productInfo.php';
    }
}

new Controller();
