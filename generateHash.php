<?php
if (!file_exists('in.txt')) {
    echo "Создайте файл in.txt рядом с этим скриптом и запишите туда пароль\n";
} else {
    $in = file_get_contents('in.txt');
    $hash = password_hash($in, PASSWORD_ARGON2ID);
    file_put_contents('out.txt', $hash . "\n");
}
