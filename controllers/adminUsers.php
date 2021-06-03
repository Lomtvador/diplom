<?php
require '../models/adminUsers.php';
require 'common.php';
class Controller
{
    private Model $model;
    function __construct()
    {
        session_start();
        if (!isset($_SESSION['id']) || $_SESSION['role'] !== 0) {
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
        $admin = file_get_contents('../views/adminUsers.html');
        $styles = '<link rel="stylesheet" href="/views/index.css">';
        $styles .= '<link rel="stylesheet" href="/views/userPage.css">';
        $navigation = file_get_contents('../views/navigation.html');
        $adminNavigation = file_get_contents('../views/adminNavigation.html');
        $admin = sprintf(
            $admin,
            $styles,
            $navigation,
            $adminNavigation,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        );
        echo $admin;
    }
    private function post()
    {
        $admin = file_get_contents('../views/adminUsers.html');
        $styles = '<link rel="stylesheet" href="/views/index.css">';
        $styles .= '<link rel="stylesheet" href="/views/userPage.css">';
        $navigation = file_get_contents('../views/navigation.html');
        $adminNavigation = file_get_contents('../views/adminNavigation.html');
        if (isset($_POST['submitId'])) {
            $id = intval($_POST['id']);
            $this->model = new Model();
            $this->model->select($id);
            $u = $this->model->user;
            $admin = sprintf(
                $admin,
                $styles,
                $navigation,
                $adminNavigation,
                $u->id,
                $u->surname,
                $u->name,
                $u->patronymic,
                $u->email,
                $u->birthday,
                $u->phoneNumber,
                $u->login
            );
            echo $admin;
        } else if (isset($_POST['submitUser'])) {
            $obj = $_POST;
            checkUser($obj, false);
            $obj['id'] = intval($obj['id']);
            $this->model = new Model();
            $this->model->update($obj);
            header('Location: /controllers/adminUsers.php');
        } else {
            header('Location: /');
            exit();
        }
    }
}
new Controller();
