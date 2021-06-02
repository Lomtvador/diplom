<?php
require '../models/adminProducts.php';
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

        $admin = file_get_contents('../views/adminProducts.html');
        $navigation = file_get_contents('../views/navigation.html');
        $adminNavigation = file_get_contents('../views/adminNavigation.html');
        $productsTable = file_get_contents('../views/productsTable.html');
        $this->model = new Model();
        $this->model->select();
        $products = '';
        for ($i = 0; $i < count($this->model->products); $i++) {
            $p = $this->model->products[$i];
            $products .= sprintf(
                $productsTable,
                $p->id,
                $p->pageCount,
                $p->titleRussian,
                $p->titleOriginal,
                $p->publicationDate,
                $p->price[0],
                $p->price[1],
                $p->description,
                $p->imagePath,
                $p->imagePath,
                $p->filePath,
                $p->filePath,
                $p->publisher,
                $p->author,
                $p->artist,
                $p->rating,
                $p->language,
                $p->category,
                $p->a19
            );
        }
        $styles = '<link rel="stylesheet" href="/views/index.css">';
        $admin = sprintf($admin, $styles, $navigation, $adminNavigation, $products);
        echo $admin;
    }
    private function post()
    {
    }
}
new Controller();
