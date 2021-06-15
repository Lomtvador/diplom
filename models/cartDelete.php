<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/database.php';
class Model
{
    private Database $db;
    function __construct(int $user, int $id)
    {
        $this->db = new Database();
        try {
            $this->db->mysqli->begin_transaction();
            $sql = 'DELETE FROM cart WHERE user = ? AND product = ?';
            $stmt = $this->db->mysqli->prepare($sql);
            $stmt->bind_param(
                'ii',
                $user,
                $id
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
