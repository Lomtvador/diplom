<?php
require '../models/register.php';
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
        $register = sprintf($register, $styles, $navigation);
        echo $register;
    }
    private function post()
    {
        $obj = [
            'surname' => $_POST['surname'],
            'name' => $_POST['name'],
            'patronymic' => $_POST['patronymic'],
            'email' => $_POST['email'],
            'birthday' => $_POST['birthday'],
            'phoneNumber' => $_POST['phoneNumber'],
            'login' => $_POST['login'],
            'password' => $_POST['password']
        ];
        $obj['phoneNumber'] = intval($obj['phoneNumber']);
        $obj['password'] = password_hash($obj['password'], PASSWORD_ARGON2ID);
        $this->model = new Model($obj);
        header('Location: /controllers/login.php');
    }
}
new Controller();
