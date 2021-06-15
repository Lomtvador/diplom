<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/register.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/common.php';
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
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/register.php';
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
