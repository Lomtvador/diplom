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
        $userPage = file_get_contents('../views/userPage.html');
        $navigation = file_get_contents('../views/navigation.html');
        $product2 = file_get_contents('../views/product2.html');
        $id = $_SESSION['id'];
        $this->model = new Model();
        $this->model->select($id);

        $products = '';
        for ($i = 0; $i < count($this->model->products); $i++) {
            $p = $this->model->products[$i];
            $id = $p->id;
            $products .= sprintf(
                $product2,
                $p->imagePath,
                $p->titleRussian,
                $p->rating,
                $p->filePath
            );
        }

        $styles = '<link rel="stylesheet" href="/views/index.css">';
        $styles .= '<link rel="stylesheet" href="/views/userPage.css">';
        $u = $this->model->user;
        $userPage = sprintf(
            $userPage,
            $styles,
            $navigation,
            $u->id,
            $u->surname,
            $u->name,
            $u->patronymic,
            $u->email,
            $u->birthday,
            $u->phoneNumber,
            $u->login,
            $products
        );
        echo $userPage;
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
        $obj['password'] = password_hash($obj['password'], PASSWORD_ARGON2ID);
        $obj['id'] = intval($_SESSION['id']);
        $this->model = new Model();
        $this->model->update($obj);
        header('Location: /controllers/userPage.php');
    }
}
new Controller();
