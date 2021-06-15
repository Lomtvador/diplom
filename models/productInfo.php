<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/product.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/message.php';
class Model extends Product
{
    private Database $db;
    public Product $product;
    function __construct($id, bool $admin = false)
    {
        $this->db = new Database();
        $row = [];
        try {
            $this->db->mysqli->begin_transaction();
            $sql = 'SELECT hidden FROM product WHERE id = ?';
            $stmt = $this->db->mysqli->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                if (!$admin) {
                    $row = $result->fetch_assoc();
                    $hidden = boolval($row['hidden']);
                    if ($hidden) {
                        $stmt->close();
                        unset($stmt);
                        $this->db->mysqli->rollback();
                        $this->db->mysqli->close();
                        new Message('Товар скрыт');
                    }
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
            $stmt = $this->db->mysqli->prepare('SELECT * FROM product WHERE id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->db->mysqli->commit();
            } else {
                $error = true;
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
        $this->product = new Product();
        $this->product->id = $row['id'];
        $this->product->type = $row['type'] === '0' ? 'Журнал' : 'Комикс';
        $this->product->pageCount = $row['pageCount'];
        $this->product->publisher = $row['publisher'];
        $this->product->titleRussian = $row['titleRussian'];
        $this->product->titleOriginal = $row['titleOriginal'];
        $this->product->author = $row['author'];
        $this->product->artist = $row['artist'];
        $this->product->publicationDate = $row['publicationDate'];
        $this->product->rating = $row['rating'];
        $this->product->price = explode('.', $row['price']);
        $this->product->price[0] = intval($this->product->price[0]);
        $this->product->price[1] = intval($this->product->price[1]);
        $this->product->description = $row['description'];
        $this->product->language = $row['language'];
        $this->product->category = $row['category'];
        $this->product->imagePath = $row['imagePath'];
        $this->product->filePath = $row['filePath'];
    }
}
