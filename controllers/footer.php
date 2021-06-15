<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/footer.php';
class FooterController
{
    private FooterModel $model;
    function __construct()
    {
        $this->model = new FooterModel();
        $u = $this->model->user;
        require $_SERVER['DOCUMENT_ROOT'] . '/views/footer.php';
    }
}
new FooterController();
