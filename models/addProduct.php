<?php
require_once 'database.php';
class Model
{
    function __construct($obj)
    {
        $this->db = new Database();
        try {
            $this->db->mysqli->begin_transaction();
            $sql = 'INSERT INTO `product` (`id`, `type`, `pageCount`, `publisher`, `titleRussian`, `titleOriginal`, `author`, `artist`, `publicationDate`, `rating`, `price`, `description`, `language`, `category`, `imagePath`, `filePath`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $stmt = $this->db->mysqli->prepare($sql);
            $stmt->bind_param(
                'iissssssissssss',
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
                $obj['filePath']
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
