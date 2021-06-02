<?php
require '../models/adminUsers.php';
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
        $admin = file_get_contents('../views/adminUsers.html');
        $navigation = file_get_contents('../views/navigation.html');
        $adminNavigation = file_get_contents('../views/adminNavigation.html');
        $usersTable = file_get_contents('../views/usersTable.html');
        $this->model = new Model();
        $this->model->select();
        $users = '';
        for ($i = 0; $i < count($this->model->users); $i++) {
            $u = $this->model->users[$i];
            $users .= sprintf(
                $usersTable,
                $u->id,
                $u->surname,
                $u->name,
                $u->patronymic,
                $u->email,
                $u->birthday,
                $u->phoneNumber,
                $u->login,
                $u->password,
                $u->a10
            );
        }
        $styles = '<link rel="stylesheet" href="/views/index.css">';
        $admin = sprintf($admin, $styles, $navigation, $adminNavigation, $users);
        echo $admin;
    }
    private function post()
    {
    }
}
new Controller();
