<?php
class Message
{
    function __construct(string $message)
    {
        $seconds = 10;
        header("Refresh:$seconds; url=/");
        require '../views/message.php';
        exit();
    }
}
