<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/product.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/database.php';
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
            $sql = 'SELECT id, imagePath, rating, publicationDate, category, titleRussian, price FROM product';
            $typesCount = 0;
            if ($category !== '') {
                $sql .= ' WHERE category = ? ';
                if (!$admin)
                    $sql .= 'AND hidden = 0';

                $typesCount++;
            } else {
                if (!$admin)
                    $sql .= ' WHERE hidden = 0';
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
            $this->limit = 12;
            $offset = $this->limit * ($page - 1);
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
                    $this->products[$i] = new Product();
                    $this->products[$i]->id = $row['id'];
                    $this->products[$i]->titleRussian = $row['titleRussian'];
                    $this->products[$i]->publicationDate = $row['publicationDate'];
                    $this->products[$i]->category = $row['category'];
                    $this->products[$i]->imagePath = $row['imagePath'];
                    $this->products[$i]->rating = $row['rating'];
                    $this->products[$i]->price = explode('.', $row['price']);
                    $this->products[$i]->price[0] = intval($this->products[$i]->price[0]);
                    $this->products[$i]->price[1] = intval($this->products[$i]->price[1]);
                    $i++;
                }
                $stmt->close();
                unset($stmt);
                $sql = 'SELECT COUNT(id) AS count FROM product';
                if ($category !== '') {
                    $sql .= ' WHERE category = ? ';
                    if (!$admin)
                        $sql .= 'AND hidden = 0';
                    $stmt = $this->db->mysqli->prepare($sql);
                    $stmt->bind_param('s', $category);
                } else {
                    if (!$admin)
                        $sql .= ' WHERE hidden = 0';
                    $stmt = $this->db->mysqli->prepare($sql);
                }
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $this->productCount = intval($row['count']);
                $this->db->mysqli->commit();
            }
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
