<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
define('DB_HOST', 'localhost'); // хост БД
define('DB_USER', 'rotot'); // пользователь БД
define('DB_PASSWORD', ''); // пароль пользователя БД
define('DB_NAME', 'sitetest'); // имя БД

// подключение к БД
try {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
} catch (mysqli_sql_exception $exception) {
    var_dump($exception);
    exit();
}
if ($mysqli->connect_errno) {
    printf("Ошибка: %s\n", $mysqli->connect_error);
    exit();
}

// Установка кодировки utf8mb4_unicode_ci
$mysqli->set_charset('utf8mb4');
$mysqli->query("SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci';");

$check_user = $mysqli->query('SELECT * FROM testtable');

if ($mysqli->errno) {
    printf("Ошибка: %s\n", $mysqli->error);
    exit();
}

if ($check_user->num_rows > 0) {

    $user = $check_user->fetch_assoc();
    $price = explode('.', $user['price']);
    $price[0] = intval($price[0]);
    $price[1] = intval($price[1]);
    var_dump($price);
}

$hash = password_hash('password123test', PASSWORD_ARGON2ID);
echo $hash;
if (password_verify('password13test', $hash)) {
    echo 'hash ok';
} else {
    echo 'hash mismatch';
}

require_once 'test1.php';
var_dump($date);
echo '<br>';
require_once 'test2.php';
