<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/message.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/download.php';
class Controller
{
    private Model $model;
    function __construct()
    {
        session_start();
        if (!isset($_SESSION['id']) || !isset($_GET['id'])) {
            header('Location: /controllers/userPage.php');
            exit();
        }
        $id = intval($_GET['id']);
        $user = $_SESSION['id'];
        $this->model = new Model($user, $id);
        $file = $_SERVER['DOCUMENT_ROOT'] . $this->model->product->filePath;
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $this->model->product->titleRussian . '.pdf"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
        } else {
            new Message('Файл не найден: ' . $this->model->product->filePath);
        }
    }
}
new Controller();
