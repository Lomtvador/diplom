<?php
require 'product.php';
require_once 'database.php';
class Model
{
    public Product $product;
    public $products;
    public function select()
    {
        $this->db = new Database();
        try {
            $this->db->mysqli->begin_transaction();
            $result = $this->db->mysqli->query('SELECT * FROM product');
            $this->products = [];
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $this->products[$i] = new ProductArray();
                    $this->products[$i]->id = $row['id'];
                    $this->products[$i]->type = $row['type'] === '0' ? 'Журнал' : 'Комикс';
                    $this->products[$i]->pageCount = $row['pageCount'];
                    $this->products[$i]->publisher = $row['publisher'];
                    $this->products[$i]->titleRussian = $row['titleRussian'];
                    $this->products[$i]->titleOriginal = $row['titleOriginal'];
                    $this->products[$i]->author = $row['author'];
                    $this->products[$i]->artist = $row['artist'];
                    $this->products[$i]->publicationDate = $row['publicationDate'];
                    switch ($row['rating']) {
                        case 0:
                            $this->products[$i]->rating = '0+';
                            break;
                        case 1:
                            $this->products[$i]->rating = '6+';
                            break;
                        case 2:
                            $this->products[$i]->rating = '12+';
                            break;
                        case 3:
                            $this->products[$i]->rating = '16+';
                            break;
                        case 4:
                        default:
                            $this->products[$i]->rating = '18+';
                    }
                    $this->products[$i]->price = explode('.', $row['price']);
                    $this->products[$i]->price[0] = intval($this->products[$i]->price[0]);
                    $this->products[$i]->price[1] = intval($this->products[$i]->price[1]);
                    $this->products[$i]->description = $row['description'];
                    $this->products[$i]->language = $row['language'];
                    $this->products[$i]->category = $row['category'];
                    $this->products[$i]->imagePath = $row['imagePath'];
                    $this->products[$i]->filePath = $row['filePath'];
                    $this->products[$i]->a19 = '/controllers/admin.php?type=1';
                    $i++;
                }
            }
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

class ProductArray extends Product
{
    public $a19;
}
