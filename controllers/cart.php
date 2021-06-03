<?php
require '../models/cart.php';
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
        $cart = file_get_contents('../views/cart.html');
        $navigation = file_get_contents('../views/navigation.html');
        $product = file_get_contents('../views/product.html');
        $id = $_SESSION['id'];
        $this->model = new Model();
        $this->model->select($id);
        $products = '';
        for ($i = 0; $i < count($this->model->products); $i++) {
            $p = $this->model->products[$i];
            $products .= sprintf(
                $product,
                $p->imagePath,
                $p->titleRussian,
                $p->rating,
                $p->price[0],
                $p->price[1],
                $p->a6,
                $p->a7,
                $p->a8,
                $p->a9
            );
        }
        $styles = '<link rel="stylesheet" href="/views/index.css">';
        $styles .= '<link rel="stylesheet" href="/views/userPage.css">';
        $cart = sprintf(
            $cart,
            $styles,
            $navigation,
            $products,
            $this->model->a1,
            $this->model->a2
        );
        echo $cart;
    }
    private function post()
    {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location: /controllers/cart.php');
            exit();
        }
        $user = $_SESSION['id'];
        $this->model = new Model();
        $this->model->insert($user);
        header('Location: /controllers/userPage.php');
    }
}
new Controller();
