<?php
require 'user.php';
require_once 'database.php';
class Model
{
    public User $user;
    public function select(int $id)
    {
        $this->db = new Database();
        try {
            $this->db->mysqli->begin_transaction();
            $sql = 'SELECT * FROM user WHERE id = ?';
            $stmt = $this->db->mysqli->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            } else {
                throw new mysqli_sql_exception();
            }
            $this->user = new User();
            $this->user->id = $row['id'];
            $this->user->surname = $row['surname'];
            $this->user->name = $row['name'];
            $this->user->patronymic = $row['patronymic'];
            $this->user->email = $row['email'];
            $this->user->birthday = $row['birthday'];
            $this->user->phoneNumber = $row['phoneNumber'];
            $this->user->login = $row['login'];
            $this->db->mysqli->commit();
        } catch (mysqli_sql_exception $exception) {
            $this->db->mysqli->rollback();
            $error = true;
        } finally {
            if (isset($stmt))
                $stmt->close();
            $this->db->mysqli->close();
            if (isset($error)) {
                header('Location: /');
                exit();
            }
        }
    }
    public function update($obj)
    {
        $this->db = new Database();
        try {
            $this->db->mysqli->begin_transaction();
            $sql = 'SELECT id, login FROM user WHERE login = ?';
            $stmt = $this->db->mysqli->prepare($sql);
            $stmt->bind_param('s', $obj['login']);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (intval($row['id']) !== intval($obj['id'])) {
                    $login = $obj['login'];
                    $this->db->mysqli->rollback();
                    $this->db->mysqli->close();
                    new Message("Логин $login уже занят.");
                }
            }
            $stmt = $this->db->mysqli->prepare('SELECT * FROM user WHERE id = ?');
            $stmt->bind_param('i', $obj['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = null;
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            } else {
                throw new mysqli_sql_exception();
            }
            $stmt->close();
            $sql = 'UPDATE `user` SET `surname` = ?, `name` = ?, `patronymic` = ?, `email` = ?, `birthday` = ?, `phoneNumber` = ?, `login` = ? WHERE `user`.`id` = ?';
            $stmt = $this->db->mysqli->prepare($sql);
            $columns = ['surname', 'name', 'patronymic', 'email', 'birthday', 'phoneNumber', 'login'];
            foreach ($columns as $c) {
                $obj[$c] = ($obj[$c] === '') ? $row[$c] : $obj[$c];
            }
            $stmt->bind_param(
                'sssssisi',
                $obj['surname'],
                $obj['name'],
                $obj['patronymic'],
                $obj['email'],
                $obj['birthday'],
                $obj['phoneNumber'],
                $obj['login'],
                $obj['id']
            );
            $stmt->execute();
            $this->db->mysqli->commit();
        } catch (mysqli_sql_exception $exception) {
            $this->db->mysqli->rollback();
            $error = true;
        } finally {
            if (isset($stmt))
                $stmt->close();
            $this->db->mysqli->close();
            if (isset($error)) {
                header('Location: /');
                exit();
            }
        }
    }
}

class UserArray extends User
{
    public $a10;
}
