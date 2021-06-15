<?php
class Message
{
    function __construct(string $message)
    {
        $seconds = 10;
        header("Refresh:$seconds; url=/");
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/message.php';
        exit();
    }
}
