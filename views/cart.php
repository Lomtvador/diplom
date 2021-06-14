<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/views/index.css">
    <link rel="stylesheet" href="/views/userPage.css">
    <title>Магазин</title>
</head>

<body>
    <div class="page">
        <div class="header">
            <?php require 'navigation.php'; ?>
        </div>
        <div class="pageWrap">
            <div class="products">
                <?php foreach ($products as $p) {
                    require 'product.php';
                }
                ?>
            </div>
            <h2>Итог: <?= $price[0] ?>,<?= $price[1] ?> ₽</h2>
            <form method="post">
                <input type="submit" value="Купить">
            </form>
        </div>
        <div class="footer"></div>
    </div>
</body>

</html>