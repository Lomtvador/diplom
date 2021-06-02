<?php
class Controller
{
    function __construct()
    {
        $code = $_GET['code'];
        if ($code === '500') {
            $page = file_get_contents('../views/error500.html');
            header("Refresh:5; url=/");
            echo $page;
        }
    }
}
new Controller();
