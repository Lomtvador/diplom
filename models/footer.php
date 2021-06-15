<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/user.php';
class FooterModel
{
    public User $user;
    function __construct()
    {
        $this->db = new Database();
        try {
            $this->db->mysqli->begin_transaction();
            $sql = 'SELECT email, phoneNumber FROM user WHERE id = 1';
            $result = $this->db->mysqli->query($sql);
            $row = $result->fetch_assoc();
            $this->user = new User();
            $this->user->email = $row['email'];
            $this->user->phoneNumber = $row['phoneNumber'];
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
