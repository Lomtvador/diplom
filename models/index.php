<?php
require 'models/product.php';
require_once 'database.php';
class Model
{
    public $products;
    public $limit;
    public $productCount;
    private Database $db;
    function __construct($category = '', $sort = 'id', $asc = true, $page = 1, bool $admin = false)
    {
        $this->db = new Database();
        $this->products = [];
        try {
            $this->db->mysqli->begin_transaction();
            if ($admin)
                $sql = 'SELECT id, imagePath, rating, titleRussian, price FROM product';
            else
                $sql = 'SELECT id, imagePath, rating, titleRussian, price FROM product WHERE hidden = 0';
            $typesCount = 0;
            if ($category !== '') {
                $sql .= ' WHERE category = ? ';
                $typesCount++;
            }
            $found = false;
            $result = $this->db->mysqli->query('SHOW COLUMNS FROM `product`');
            while ($row = $result->fetch_assoc()) {
                if ($row['Field'] === $sort) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                throw new mysqli_sql_exception();
            }
            $sql .= " ORDER BY $sort ";
            if ($asc) {
                $sql .= ' ASC ';
            } else {
                $sql .= ' DESC ';
            }
            $sql .= ' LIMIT ? OFFSET ? ';
            $this->limit = 6;
            $offset = 2 * ($page - 1);
            $stmt = $this->db->mysqli->prepare($sql);
            if ($typesCount === 1) {
                $stmt->bind_param('sii', $category, $this->limit, $offset);
            } else {
                $stmt->bind_param('ii', $this->limit, $offset);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    $this->products[$i] = new ProductArray();
                    $this->products[$i]->titleRussian = $row['titleRussian'];
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
                    $this->products[$i]->imagePath = $row['imagePath'];
                    $this->products[$i]->price = explode('.', $row['price']);
                    $this->products[$i]->price[0] = intval($this->products[$i]->price[0]);
                    $this->products[$i]->price[1] = intval($this->products[$i]->price[1]);
                    $this->products[$i]->a6 = 'cartAdd';
                    $this->products[$i]->a7 = "/controllers/cartAdd.php?id=$id";
                    $this->products[$i]->a8 = 'Добавить в корзину';
                    $this->products[$i]->a9 = "/controllers/productInfo.php?id=$id";
                    $i++;
                }
                $stmt->close();
                $sql = 'SELECT COUNT(id) AS count FROM product';
                if ($category !== '') {
                    $sql .= ' WHERE category = ? ';
                    $stmt = $this->db->mysqli->prepare($sql);
                    $stmt->bind_param('s', $category);
                } else {
                    $stmt = $this->db->mysqli->prepare($sql);
                }
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $this->productCount = intval($row['count']);
                $this->db->mysqli->commit();
            }
        } catch (mysqli_sql_exception $exception) {
            //var_dump($exception);
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
    public $a6;
    public $a7;
    public $a8;
    public $a9;
}
