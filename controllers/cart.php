<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/cart.php';
class Controller
{
    private Model $model;
    function __construct()
    {
        session_start();
        if (!isset($_SESSION['id']) || $_SESSION['role'] === 0) {
            header('Location: /controllers/login.php');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->get();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->post();
        }
    }
    private function get()
    {
        $id = $_SESSION['id'];
        $this->model = new Model();
        $this->model->select($id);
        $products = $this->model->products;
        $price = $this->model->price;
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/cart.php';
    }
    private function post()
    {
        $user = $_SESSION['id'];
        $this->model = new Model();
        $this->model->insert($user);
        header('Location: /controllers/userPage.php');
    }
}
new Controller();
