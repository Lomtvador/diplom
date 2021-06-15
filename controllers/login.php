<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/login.php';
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
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/login.php';
    }
    private function post()
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $this->model = new Model($login, $password);
        if ($this->model->logged) {
            session_start();
            $_SESSION['id'] = $this->model->id;
            $_SESSION['role'] = $this->model->role;
            header('Location: /controllers/userPage.php');
        } else {
            header('Location: /controllers/login.php');
        }
    }
}
new Controller();
