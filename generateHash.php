<?php
if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/in.txt')) {
    echo "Создайте файл in.txt рядом с этим скриптом и запишите туда пароль\n";
} else {
    $in = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/in.txt');
    $hash = password_hash($in, PASSWORD_ARGON2ID);
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/out.txt', $hash . "\n");
}
