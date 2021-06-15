<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/cartAdd.php';
class Controller
{
    private Model $model;
    function __construct()
    {
        session_start();
        if (!isset($_SESSION['id']) || $_SESSION['role'] === 0 || !isset($_GET['id'])) {
            header('Location: /controllers/cart.php');
            exit();
        }
        $id = intval($_GET['id']);
        $user = $_SESSION['id'];
        $this->model = new Model($user, $id);
        header('Location: /controllers/cart.php');
    }
}
new Controller();
