<?php
require_once 'models/database.php';
$db = new Database();
try {
    $paths = array(
        '/images/placeholder1.png',
        '/images/placeholder2.jpg',
        '/images/placeholder3.jpg',
        '/images/placeholder4.png',
        '/images/placeholder5.png',
        '/images/placeholder6.png',
        '/images/placeholder7.jpg',
        '/images/placeholder8.jpg',
        '/images/placeholder9.jpg'
    );
    $db->mysqli->begin_transaction();
    $sql = 'SELECT id FROM product ORDER BY RAND()';
    $result = $db->mysqli->query($sql);
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        $sql = 'UPDATE `product` SET `imagePath` = ? WHERE `product`.`id` = ?';
        $stmt = $db->mysqli->prepare($sql);
        if (1 <= $i && $i <= 100) {
            $p = '/images/placeholder1.png';
        } elseif (100 < $i && $i <= 200) {
            $p = '/images/placeholder2.jpg';
        } elseif (200 < $i && $i <= 300) {
            $p = '/images/placeholder3.jpg';
        } elseif (300 < $i && $i <= 400) {
            $p = '/images/placeholder4.png';
        } elseif (400 < $i && $i <= 500) {
            $p = '/images/placeholder5.png';
        } elseif (500 < $i && $i <= 600) {
            $p = '/images/placeholder6.png';
        } elseif (600 < $i && $i <= 700) {
            $p = '/images/placeholder7.jpg';
        } elseif (700 < $i && $i <= 800) {
            $p = '/images/placeholder8.jpg';
        } elseif (800 < $i && $i <= 900) {
            $p = '/images/placeholder9.jpg';
        } elseif (900 < $i && $i <= 1000) {
            $p = '/images/placeholder2.jpg';
        }
        $stmt->bind_param('si', $p, $row['id']);
        $stmt->execute();
        $i++;
    }
    $db->mysqli->commit();
} catch (mysqli_sql_exception $exception) {
    $db->mysqli->rollback();
    $error = true;
} finally {
    if (isset($stmt))
        $stmt->close();
    $db->mysqli->close();
    if (isset($error)) {
        header('Location: /');
        exit();
    }
}
