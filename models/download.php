<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/message.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/product.php';
class Model
{
    public Product $product;
    function __construct(int $user, int $id)
    {
        $this->db = new Database();
        try {
            $this->db->mysqli->begin_transaction();
            $sql = <<<EOT
            SELECT product.filePath, product.titleRussian FROM user, product, userproduct
            WHERE userproduct.user = user.id
            AND userproduct.product = product.id
            AND userproduct.user = ?
            AND userproduct.product = ?
            EOT;
            $stmt = $this->db->mysqli->prepare($sql);
            $stmt->bind_param('ii', $user, $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->product = new Product();
                $this->product->filePath = $row['filePath'];
                $this->product->titleRussian = $row['titleRussian'];
            } else {
                $stmt->close();
                unset($stmt);
                $this->db->mysqli->rollback();
                $this->db->mysqli->close();
                new Message('Товар не найден');
            }
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
