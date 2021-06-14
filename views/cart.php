<?php require_once 'common.php'; ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/views/common.css">
    <link rel="stylesheet" href="/views/form.css">
    <title>Магазин</title>
</head>

<body>
    <div class="page">
        <div class="header">
            <?php require 'navigation.php'; ?>
        </div>
        <div class="pageWrap">
            <div class="products">
                <?php
                $class = 'cartDelete';
                $text = 'Удалить из корзины';
                foreach ($products as $p) {
                    require 'product.php';
                }
                ?>
            </div>
            <h2>Итог: <?= formatPrice($price); ?></h2>
            <form method="post">
                <input type="submit" value="Купить">
            </form>
        </div>
        <div class="footer"></div>
    </div>
</body>

</html>