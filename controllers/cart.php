<?php
require '../models/cart.php';
class Controller
{
    private Model $model;
    function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->get();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->post();
        }
    }
    private function get()
    {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location: /controllers/login.php');
            exit();
        }
        $id = $_SESSION['id'];
        $this->model = new Model();
        $this->model->select($id);
        $products = $this->model->products;
        $price = [$this->model->a1, $this->model->a2];
        require '../views/cart.php';
    }
    private function post()
    {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location: /controllers/cart.php');
            exit();
        }
        $user = $_SESSION['id'];
        $this->model = new Model();
        $this->model->insert($user);
        header('Location: /controllers/userPage.php');
    }
}
new Controller();
