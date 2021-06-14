<?php
require 'product.php';
require_once 'database.php';
class Model
{
    public Database $db;
    public $products;
    public $price;
    public function select(int $id)
    {
        $this->db = new Database();
        $this->products = [];
        try {
            $this->db->mysqli->begin_transaction();
            $sql = <<<EOT
            SELECT product.id, imagePath, rating, publicationDate, category, titleRussian, price, status
            FROM user, product, cart
            WHERE user.id = cart.user
            AND product.id = cart.product
            AND cart.user = ?
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
                    $this->products[$i]->publicationDate = $row['publicationDate'];
                    $this->products[$i]->category = $row['category'];
                    $this->products[$i]->titleRussian = $row['titleRussian'];
                    $this->products[$i]->rating = $row['rating'];
                    $this->products[$i]->price = explode('.', $row['price']);
                    $this->products[$i]->price[0] = intval($this->products[$i]->price[0]);
                    $this->products[$i]->price[1] = intval($this->products[$i]->price[1]);
                    $this->products[$i]->status = $row['status'];
                    $i++;
                }
            }
            $stmt->close();
            unset($stmt);
            $sql = 'SELECT SUM(price) FROM product, cart WHERE cart.product = product.id AND cart.user = ?';
            $stmt = $this->db->mysqli->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if (isset($row['SUM(price)']))
                $this->price = explode('.', $row['SUM(price)']);
            else
                $this->price = [0, 0];
            $this->price[0] = intval($this->price[0]);
            $this->price[1] = intval($this->price[1]);
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
    public function insert(int $user)
    {
        $this->db = new Database();
        try {
            $this->db->mysqli->begin_transaction();
            $sql = <<<EOT
            INSERT INTO `userproduct` (`id`, `user`, `product`, `purchaseDate`, `price`)
            SELECT NULL, cart.user, cart.product, CURRENT_DATE(), product.price FROM product, cart
            WHERE cart.product = product.id
            AND cart.user = ?
            EOT;
            $stmt = $this->db->mysqli->prepare($sql);
            $stmt->bind_param(
                'i',
                $user
            );
            $stmt->execute();
            $stmt->close();
            unset($stmt);
            $sql = 'DELETE FROM cart WHERE user = ?';
            $stmt = $this->db->mysqli->prepare($sql);
            $stmt->bind_param(
                'i',
                $user
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
