<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/message.php';
class Model
{
    private Database $db;
    function __construct(int $user, int $id)
    {
        $this->db = new Database();
        try {
            $this->db->mysqli->begin_transaction();
            $sql = 'SELECT hidden FROM product WHERE id = ?';
            $stmt = $this->db->mysqli->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hidden = boolval($row['hidden']);
                if ($hidden) {
                    $stmt->close();
                    unset($stmt);
                    $this->db->mysqli->rollback();
                    $this->db->mysqli->close();
                    new Message('Товар скрыт');
                }
            } else {
                $stmt->close();
                unset($stmt);
                $this->db->mysqli->rollback();
                $this->db->mysqli->close();
                new Message('Товар не найден');
            }
            $stmt->close();
            unset($stmt);
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
                unset($stmt);
                $this->db->mysqli->rollback();
                $this->db->mysqli->close();
                new Message('Товар уже есть в корзине');
            }
            $stmt->close();
            unset($stmt);
            $sql = 'SELECT id FROM userproduct WHERE user = ? AND product = ?';
            $stmt = $this->db->mysqli->prepare($sql);
            $stmt->bind_param('ii', $user,  $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            unset($stmt);
            if ($result->num_rows > 0) {
                $this->db->mysqli->rollback();
                $this->db->mysqli->close();
                new Message('Продукт уже куплен, зайдите в личный кабинет');
            }
            $sql = 'SELECT user.birthday, product.rating FROM user, product WHERE user.id = ? AND product.id = ?';
            $stmt = $this->db->mysqli->prepare($sql);
            $stmt->bind_param('ii', $user, $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            unset($stmt);
            $row = $result->fetch_assoc();
            $rating = [0, 6, 12, 16, 18];
            $birthday = DateTime::createFromFormat('Y-m-d', $row['birthday']);
            $currentDay = new DateTime();
            $diff = $currentDay->diff($birthday);
            $age = $diff->y;
            if ($age < $rating[$row['rating']]) {
                $this->db->mysqli->rollback();
                $this->db->mysqli->close();
                new Message('Этот товар доступен только для лиц старше ' . $rating[$row['rating']] . " лет. Вам $age лет.");
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
