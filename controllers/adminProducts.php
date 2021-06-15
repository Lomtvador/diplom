<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/adminProducts.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/common.php';
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
        $p = $this->model->product;
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/adminProducts.php';
    }
    private function post()
    {
        $obj = $_POST;
        if (isset($_POST['submitId'])) {
            $id = intval($_POST['id']);
            $this->model = new Model();
            $this->model->select($id);
            $p = $this->model->product;
            require_once $_SERVER['DOCUMENT_ROOT'] . '/views/adminProducts.php';
        } else if (isset($_POST['submitProduct'])) {
            checkProduct($obj, false);
            if (!(isset($_FILES['image']) && $_FILES['image']['size'] !== 0)) {
                $obj['imagePath'] = '';
            } else {
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
                $obj['imagePath'] = '/images/' . pathinfo($imagePath, PATHINFO_BASENAME);
            }
            if (!(isset($_FILES['file']) && $_FILES['file']['size'] !== 0)) {
                $obj['filePath'] = '';
            } else {
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
                $obj['filePath'] = '/products/' . pathinfo($filePath, PATHINFO_BASENAME);
            }
            $this->model = new Model();
            $this->model->update($obj);
            header('Location: /controllers/adminProducts.php');
        } else {
            header('Location: /');
            exit();
        }
    }
}
new Controller();
