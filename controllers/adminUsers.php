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
        $this->model = new Model();
        $u = $this->model->user;
        require '../views/adminUsers.php';
    }
    private function post()
    {
        if (isset($_POST['submitId'])) {
            $id = intval($_POST['id']);
            $this->model = new Model();
            $this->model->select($id);
            $u = $this->model->user;
            require '../views/adminUsers.php';
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
