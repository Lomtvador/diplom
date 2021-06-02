<?php
require '../models/login.php';
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
        $login = file_get_contents('../views/login.html');
        $navigation = file_get_contents('../views/navigation.html');
        $styles = '<link rel="stylesheet" href="/views/index.css">';
        $login = sprintf($login, $styles, $navigation);
        echo $login;
    }
    private function post()
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $this->model = new Model($login, $password);
        if ($this->model->logged) {
            session_start();
            $_SESSION['id'] = $this->model->id;
            header('Location: /controllers/userPage.php');
        } else {
            header('Location: /controllers/login.php');
        }
    }
}
new Controller();
