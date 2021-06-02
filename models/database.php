<?php
class Database
{
    public $mysqli;
    function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            // подключение к БД
            $this->mysqli = new mysqli(
                // хост БД
                'localhost',
                // пользователь БД
                'coJ438cTHgcqwd',
                // пароль пользователя БД
                'PtQ5zjj8Bg]kocq',
                // имя БД
                'website'
            );
            // if ($this->mysqli->connect_errno) {
            //     printf("Ошибка: %s\n", $this->mysqli->connect_error);
            //     exit();
            // }
            // Установка кодировки utf8mb4_unicode_ci
            $this->mysqli->set_charset('utf8mb4');
            $this->mysqli->query("SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci';");
        } catch (mysqli_sql_exception $exception) {
            var_dump($exception);
            exit();
        }
    }
}
