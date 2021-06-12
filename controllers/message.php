<?php
class Message
{
    function __construct(string $message)
    {
        $seconds = 5;
        $page = file_get_contents('../views/message.html');
        $page = sprintf($page, $message, $seconds);
        header("Refresh:$seconds; url=/");
        echo $page;
        exit();
    }
}
