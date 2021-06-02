<?php
class Controller
{
    function __construct()
    {
        $admin = file_get_contents('../views/admin.html');
        $navigation = file_get_contents('../views/navigation.html');
        $adminNavigation = file_get_contents('../views/adminNavigation.html');
        $styles = '<link rel="stylesheet" href="/views/index.css">';
        $admin = sprintf($admin, $styles, $navigation, $adminNavigation);
        echo $admin;
    }
}
new Controller();
