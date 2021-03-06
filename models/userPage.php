<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/user.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/product.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/database.php';
class Model
{
    public User $user;
    public $products;
    public $limit;
    public $productCount;
    public function select(int $id)
    {
        $this->db = new Database();
        try {
            $this->db->mysqli->begin_transaction();
            $stmt = $this->db->mysqli->prepare('SELECT * FROM user WHERE id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->user = new User();
                $this->user->id = $row['id'];
                $this->user->surname = $row['surname'];
                $this->user->name = $row['name'];
                $this->user->patronymic = $row['patronymic'];
                $this->user->email = $row['email'];
                $this->user->birthday = $row['birthday'];
                $this->user->phoneNumber = $row['phoneNumber'];
                $this->user->login = $row['login'];
                $this->user->role = $row['role'];
            } else {
                throw new mysqli_sql_exception();
            }

            $sql = <<<EOT
            SELECT product.id, imagePath, filePath, rating, titleRussian
            FROM user, product, userproduct
            WHERE user.id = userproduct.user
            AND product.id = userproduct.product
            AND userproduct.user = ?
            EOT;
            $stmt = $this->db->mysqli->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $this->products = [];
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $this->products[$i] = new Product();
                    $this->products[$i]->id = $row['id'];
                    $this->products[$i]->imagePath = $row['imagePath'];
                    $this->products[$i]->rating = $row['rating'];
                    $this->products[$i]->titleRussian = $row['titleRussian'];
                    $this->products[$i]->filePath = $row['filePath'];
                    $i++;
                }
            }
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
            unset($stmt);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (intval($row['id']) !== intval($obj['id'])) {
                    $login = $obj['login'];
                    $this->db->mysqli->rollback();
                    $this->db->mysqli->close();
                    new Message("?????????? $login ?????? ??????????.");
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
            unset($stmt);
            $sql = 'UPDATE `user` SET `surname` = ?, `name` = ?, `patronymic` = ?, `email` = ?, `birthday` = ?, `phoneNumber` = ?, `login` = ?, `password` = ? WHERE `user`.`id` = ?';
            $stmt = $this->db->mysqli->prepare($sql);
            $columns = ['surname', 'name', 'email', 'birthday', 'phoneNumber', 'login', 'password'];
            foreach ($columns as $c) {
                $obj[$c] = ($obj[$c] === '') ? $row[$c] : $obj[$c];
            }
            $stmt->bind_param(
                'sssssissi',
                $obj['surname'],
                $obj['name'],
                $obj['patronymic'],
                $obj['email'],
                $obj['birthday'],
                $obj['phoneNumber'],
                $obj['login'],
                $obj['password'],
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
