<?php
require 'user.php';
require_once 'database.php';
class Model
{
    public $users;
    public function select()
    {
        $this->db = new Database();
        try {
            $this->db->mysqli->begin_transaction();
            $result = $this->db->mysqli->query('SELECT * FROM user');
            $this->users = [];
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $this->users[$i] = new UserArray();
                    $this->users[$i]->id = $row['id'];
                    $this->users[$i]->surname = $row['surname'];
                    $this->users[$i]->name = $row['name'];
                    $this->users[$i]->patronymic = $row['patronymic'];
                    $this->users[$i]->email = $row['email'];
                    $this->users[$i]->birthday = $row['birthday'];
                    $this->users[$i]->phoneNumber = $row['phoneNumber'];
                    $this->users[$i]->login = $row['login'];
                    $this->users[$i]->password = $row['password'];
                    $this->users[$i]->role = $row['role'];
                    $this->users[$i]->a10 = '/controllers/admin.php?type=0';
                    $i++;
                }
            }
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
                header('Location: /');
                exit();
            }
        }
    }
    public function insert()
    {
    }
}

class UserArray extends User
{
    public $a10;
}
