<?php
require_once 'database.php';
class Model
{
    private Database $db;
    function __construct(int $user, int $id)
    {
        $this->db = new Database();
        try {
            $this->db->mysqli->begin_transaction();
            $sql = 'INSERT INTO `cart` (`id`, `status`, `user`, `product`) VALUES (NULL, 0, ?, ?)';
            $stmt = $this->db->mysqli->prepare($sql);
            $stmt->bind_param(
                'ii',
                $user,
                $id
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
