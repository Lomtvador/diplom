<?php
require_once 'database.php';
require_once 'message.php';
class Model
{
    function __construct($obj)
    {
        $this->db = new Database();
        try {
            $this->db->mysqli->begin_transaction();
            $sql = 'SELECT login FROM user WHERE login = ?';
            $stmt = $this->db->mysqli->prepare($sql);
            $stmt->bind_param('s', $obj['login']);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                $login = $obj['login'];
                $this->db->mysqli->rollback();
                $this->db->mysqli->close();
                new Message("Логин $login уже занят.");
            }
            $sql = 'INSERT INTO `user` (`id`, `surname`, `name`, `patronymic`, `email`, `birthday`, `phoneNumber`, `login`, `password`, `role`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, 1)';
            $stmt = $this->db->mysqli->prepare($sql);
            $stmt->bind_param(
                'sssssiss',
                $obj['surname'],
                $obj['name'],
                $obj['patronymic'],
                $obj['email'],
                $obj['birthday'],
                $obj['phoneNumber'],
                $obj['login'],
                $obj['password']
            );
            $stmt->execute();
            $this->db->mysqli->commit();
        } catch (mysqli_sql_exception $exception) {
            var_dump($exception);
            $this->db->mysqli->rollback();
            $error = true;
        } finally {
            if (isset($stmt))
                $stmt->close();
            $this->db->mysqli->close();
            if (isset($error)) {
                header('Location: /controllers/error.php?code=500');
                exit();
            }
        }
    }
}
