<?php
require '../models/register.php';
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
        $register = file_get_contents('../views/register.html');
        $navigation = file_get_contents('../views/navigation.html');
        $styles = '<link rel="stylesheet" href="/views/index.css">';
        $styles .= '<link rel="stylesheet" href="/views/userPage.css">';
        $register = sprintf($register, $styles, $navigation);
        echo $register;
    }
    private function post()
    {
        $obj = $_POST;
        checkUser($obj);
        $obj['password'] = password_hash($obj['password'], PASSWORD_ARGON2ID);
        $this->model = new Model($obj);
        header('Location: /controllers/login.php');
    }
}
new Controller();
