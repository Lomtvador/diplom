<?php
require '../models/addProduct.php';
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
        $admin = file_get_contents('../views/addProduct.html');
        $navigation = file_get_contents('../views/navigation.html');
        $adminNavigation = file_get_contents('../views/adminNavigation.html');
        $styles = '<link rel="stylesheet" href="/views/index.css">';
        $styles .= '<link rel="stylesheet" href="/views/userPage.css">';
        $admin = sprintf($admin, $styles, $navigation, $adminNavigation);
        echo $admin;
    }
    private function post()
    {
        $dt = new DateTime();
        $filename = $dt->format('Y_m_d_H_i_s_v');
        $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/images/';
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imagePath = '';
        $i = 0;
        do {
            $imagePath = sprintf(
                '%s%s_%d.%s',
                $uploaddir,
                $filename,
                $i,
                $ext
            );
            $i++;
        } while (file_exists($imagePath));
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        $dt = new DateTime();
        $filename = $dt->format('Y_m_d_H_i_s_v');
        $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/products/';
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $i = 0;
        do {
            $filePath = sprintf(
                '%s%s_%d.%s',
                $uploaddir,
                $filename,
                $i,
                $ext
            );
            $i++;
        } while (file_exists($filePath));
        move_uploaded_file($_FILES['file']['tmp_name'], $filePath);
        $obj = $_POST;
        $price = [];
        $price[0] = intval($_POST['price1']);
        $price[1] = intval($_POST['price2']);
        $obj['price'] = $price[0] . '.' . $price[1];
        $obj['imagePath'] = '/images/' . pathinfo($imagePath, PATHINFO_BASENAME);
        $obj['filePath'] = '/products/' . pathinfo($filePath, PATHINFO_BASENAME);
        $this->model = new Model($obj);
        header('Location: /');
    }
}
new Controller();
