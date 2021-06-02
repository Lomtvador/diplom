<?php
require '../models/productInfo.php';
class Controller
{
    private Model $model;
    function __construct()
    {
        if (!isset($_GET['id'])) {
            header('Location: /');
            exit();
        }
        $id = intval($_GET['id']);
        $productInfo = file_get_contents('../views/productInfo.html');
        $navigation = file_get_contents('../views/navigation.html');
        $this->model = new Model($id);
        $styles = '<link rel="stylesheet" href="/views/index.css">';
        $m = $this->model;
        $productInfo = sprintf(
            $productInfo,
            $styles,
            $navigation,
            $m->imagePath,
            $m->type,
            $m->pageCount,
            $m->publisher,
            $m->author,
            $m->titleRussian,
            $m->titleOriginal,
            $m->artist,
            $m->publicationDate,
            $m->rating,
            $m->price[0],
            $m->price[1],
            $m->description,
            $m->language,
            $m->cartAdd
        );
        echo $productInfo;
    }
}

new Controller();
