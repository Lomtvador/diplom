<?php
require 'product.php';
require_once 'database.php';
class Model
{
    public Database $db;
    public $products;
    public $a1;
    public $a2;
    public $a3;
    public function select(int $id)
    {
        $this->db = new Database();
        $this->products = [];
        try {
            $this->db->mysqli->begin_transaction();
            $sql = <<<EOT
            SELECT product.id, imagePath, rating, titleRussian, price, status
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
                    $this->products[$i] = new ProductArray();
                    $this->products[$i]->id = $row['id'];
                    $productid = $this->products[$i]->id;
                    $this->products[$i]->imagePath = $row['imagePath'];
                    $this->products[$i]->rating = '/images/rating/';
                    switch ($row['rating']) {
                        case 0:
                            $this->products[$i]->rating .= '0.png';
                            break;
                        case 1:
                            $this->products[$i]->rating .= '6.png';
                            break;
                        case 2:
                            $this->products[$i]->rating .= '12.png';
                            break;
                        case 3:
                            $this->products[$i]->rating .= '16.png';
                            break;
                        case 4:
                        default:
                            $this->products[$i]->rating .= '18.png';
                    }
                    $this->products[$i]->titleRussian = $row['titleRussian'];
                    $this->products[$i]->price = explode('.', $row['price']);
                    $this->products[$i]->price[0] = intval($this->products[$i]->price[0]);
                    $this->products[$i]->price[1] = intval($this->products[$i]->price[1]);
                    $this->products[$i]->status = $row['status'];
                    $this->products[$i]->a6 = 'cartDelete';
                    $this->products[$i]->a7 = "/controllers/cartDelete.php?id=$productid";
                    $this->products[$i]->a8 = 'Удалить из корзины';
                    $this->products[$i]->a9 = "/controllers/productInfo.php?id=$productid";
                    $i++;
                }
            }
            $stmt->close();
            $sql = 'SELECT SUM(price) FROM product, cart WHERE cart.product = product.id AND cart.user = ?';
            $stmt = $this->db->mysqli->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if (isset($row['SUM(price)']))
                $price = explode('.', $row['SUM(price)']);
            else
                $price = [0, 0];
            $price[0] = intval($price[0]);
            $price[1] = intval($price[1]);
            $this->a1 = $price[0];
            $this->a2 = $price[1];
            $this->a3 = '/controllers/cart.php';
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

class ProductArray extends Product
{
    public $status;
    public $a4;
    public $a5;
    public $a6;
    public $a7;
    public $a8;
    public $a9;
}
