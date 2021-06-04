<?php
require 'product.php';
require_once 'database.php';
class Model
{
    public ProductArray $product;
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
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            } else {
                throw new mysqli_sql_exception();
            }
            $this->product = new ProductArray();
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
            $this->product->priceArray = explode('.', $row['price']);
            $this->product->priceArray[0] = intval($this->product->priceArray[0]);
            $this->product->priceArray[1] = intval($this->product->priceArray[1]);
            $this->product->description = $row['description'];
            $this->product->language = $row['language'];
            $this->product->category = $row['category'];
            $this->product->hidden = $row['hidden'];
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
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            } else {
                throw new mysqli_sql_exception();
            }
            $stmt->close();
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
                //header('Location: /');
                exit();
            }
        }
    }
}

class ProductArray extends Product
{
    public $priceArray;
}
