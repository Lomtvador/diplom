<?php
require 'product.php';
require_once 'database.php';
require_once '../controllers/message.php';
class Model extends Product
{
    public $cartAdd;
    private Database $db;
    function __construct($id)
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
                $row = $result->fetch_assoc();
                $hidden = boolval($row['hidden']);
                if ($hidden) {
                    $stmt->close();
                    $this->db->mysqli->rollback();
                    $this->db->mysqli->close();
                    new Message('Товар скрыт');
                }
            } else {
                $stmt->close();
                $this->db->mysqli->rollback();
                $this->db->mysqli->close();
                new Message('Товар не найден');
            }
            $stmt->close();
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
            var_dump($exception);
            $this->db->mysqli->rollback();
            $error = true;
        } finally {
            $stmt->close();
            $this->db->mysqli->close();
            if (isset($error)) {
                header('Location: /');
                exit();
            }
        }
        $this->id = $row['id'];
        $this->type = $row['type'] === '0' ? 'Журнал' : 'Комикс';
        $this->pageCount = $row['pageCount'];
        $this->publisher = $row['publisher'];
        $this->titleRussian = $row['titleRussian'];
        $this->titleOriginal = $row['titleOriginal'];
        $this->author = $row['author'];
        $this->artist = $row['artist'];
        $this->publicationDate = $row['publicationDate'];
        switch ($row['rating']) {
            case 0:
                $this->rating = '0+';
                break;
            case 1:
                $this->rating = '6+';
                break;
            case 2:
                $this->rating = '12+';
                break;
            case 3:
                $this->rating = '16+';
                break;
            case 4:
            default:
                $this->rating = '18+';
        }
        $this->price = explode('.', $row['price']);
        $this->price[0] = intval($this->price[0]);
        $this->price[1] = intval($this->price[1]);
        $this->description = $row['description'];
        $this->language = $row['language'];
        $this->category = $row['category'];
        $this->imagePath = $row['imagePath'];
        $this->filePath = $row['filePath'];
        $this->cartAdd = '/controllers/cart.php?add=' . $this->id;
    }
}
