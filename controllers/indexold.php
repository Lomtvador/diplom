<?php

namespace Index;

require 'models/index.php';
require 'views/index.php';

class Controller
{
    private Model $model;
    private View $view;
    function __construct()
    {
        if (!isset($_GET['name']) || !isset($_GET['surname'])) {
            $name = 'Илья';
            $surname = 'Шабалин';
        } else {
            $name = $_GET['name'];
            $surname = $_GET['surname'];
        }

        $this->model = new Model($name, $surname);
        $this->view = new View($this->model->getData());
        $page = $this->view->getPage();

        echo $page;
    }
}
