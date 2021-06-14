<?php
require '../models/userPage.php';
require 'common.php';
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
        $u = $this->model->user;
        require '../views/userPage.php';
    }
    private function post()
    {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location: /controllers/login.php');
            exit();
        }
        $obj = $_POST;
        checkUser($obj, false);
        if ($obj['password'] !== '')
            $obj['password'] = password_hash($obj['password'], PASSWORD_ARGON2ID);
        $obj['id'] = intval($_SESSION['id']);
        $this->model = new Model();
        $this->model->update($obj);
        header('Location: /controllers/userPage.php');
    }
}
new Controller();
