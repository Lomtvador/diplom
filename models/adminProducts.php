<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/product.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/database.php';
class Model
{
    public Product $product;
    function __construct()
    {
        $this->product = new Product();
        $this->product->id = '';
        $this->product->type = '';
        $this->product->pageCount = '';
        $this->product->publisher = '';
        $this->product->titleRussian = '';
        $this->product->titleOriginal = '';
        $this->product->author = '';
        $this->product->artist = '';
        $this->product->publicationDate = '';
        $this->product->rating = '';
        $this->product->price = '';
        $this->product->description = '';
        $this->product->language = '';
        $this->product->category = '';
        $this->product->imagePath = '';
        $this->product->filePath = '';
        $this->product->hidden = '';
        $this->product->priceArray = '';
    }
    public function select(int $id)
    {
        $this->db = new Database();
        try {
            $this->db->mysqli->begin_transaction();
            $sql = 'SELECT * FROM product WHERE id = ?';
            $stmt = $this->db->mysqli->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            unset($stmt);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            } else {
                $this->db->mysqli->rollback();
                $this->db->mysqli->close();
                new Message("Товар с идентификатором $id не найден");
            }
            $this->product = new Product();
            $this->product->id = $row['id'];
            $this->product->type = $row['type'];
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
            $this->product->hidden = $row['hidden'];
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
    public function update($obj)
    {
        $this->db = new Database();
        try {
            $this->db->mysqli->begin_transaction();
            $stmt = $this->db->mysqli->prepare('SELECT * FROM product WHERE id = ?');
            $stmt->bind_param('i', $obj['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = null;
            $stmt->close();
            unset($stmt);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            } else {
                $this->db->mysqli->rollback();
                $this->db->mysqli->close();
                $id = $obj['id'];
                new Message("Товар с идентификатором $id не найден");
            }
            $sql = 'UPDATE `product` SET `type` = ?, `pageCount` = ?, `publisher` = ?, `titleRussian` = ?, `titleOriginal` = ?, `author` = ?, `artist` = ?, `publicationDate` = ?, `rating` = ?, `price` = ?, `description` = ?, `language` = ?, `category` = ?, `imagePath` = ?, `filePath` = ?, `hidden` = ? WHERE `product`.`id` = ?';
            $stmt = $this->db->mysqli->prepare($sql);
            $columns = ['type', 'pageCount', 'publisher', 'titleRussian', 'titleOriginal', 'author', 'artist', 'publicationDate', 'rating', 'price', 'description', 'language', 'category', 'imagePath', 'filePath'];
            foreach ($columns as $c) {
                $obj[$c] = ($obj[$c] === '') ? $row[$c] : $obj[$c];
            }
            $stmt->bind_param(
                'iissssssissssssii',
                $obj['type'],
                $obj['pageCount'],
                $obj['publisher'],
                $obj['titleRussian'],
                $obj['titleOriginal'],
                $obj['author'],
                $obj['artist'],
                $obj['publicationDate'],
                $obj['rating'],
                $obj['price'],
                $obj['description'],
                $obj['language'],
                $obj['category'],
                $obj['imagePath'],
                $obj['filePath'],
                $obj['hidden'],
                $obj['id']
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
                header('Location: /');
                exit();
            }
        }
    }
}
