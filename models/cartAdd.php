<?php
require_once 'database.php';
require_once 'message.php';
class Model
{
    private Database $db;
    function __construct(int $user, int $id)
    {
        $this->db = new Database();
        try {
            $this->db->mysqli->begin_transaction();
            $sql = <<<EOT
            SELECT product.id
            FROM user, product, cart
            WHERE user.id = cart.user
            AND product.id = cart.product
            AND cart.user = ?
            AND product.id = ?
            EOT;
            $stmt = $this->db->mysqli->prepare($sql);
            $stmt->bind_param('ii', $user,  $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $stmt->close();
                $this->db->mysqli->rollback();
                $this->db->mysqli->close();
                new Message('Товар уже есть в корзине');
            }
            $stmt->close();
            $sql = 'SELECT id FROM userproduct WHERE user = ? AND product = ?';
            $stmt = $this->db->mysqli->prepare($sql);
            $stmt->bind_param('ii', $user,  $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                $this->db->mysqli->rollback();
                $this->db->mysqli->close();
                new Message('Продукт уже куплен, зайдите в личный кабинет');
            }
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
