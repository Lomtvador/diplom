<?php
class Message
{
    function __construct(string $message)
    {
        $page = file_get_contents('../views/message.html');
        $page = sprintf($page, $message);
        header("Refresh:5; url=/");
        echo $page;
        exit();
    }
}
