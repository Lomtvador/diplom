<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/database.php';
class Model
{
    public bool $logged;
    public int $id;
    public int $role;
    public Database $db;
    private string $hash;
    function __construct(string $login, string $password)
    {
        $this->db = new Database();
        try {
            $this->db->mysqli->begin_transaction();
            $stmt = $this->db->mysqli->prepare('SELECT id, role, password FROM user WHERE login = ?');
            $stmt->bind_param('s', $login);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->id = $row['id'];
                $this->role = $row['role'];
                $this->hash = $row['password'];
                $this->logged = password_verify($password, $this->hash);
            } else {
                $this->logged = false;
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
}
