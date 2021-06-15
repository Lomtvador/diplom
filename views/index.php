<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/views/common.css">
    <title>Магазин</title>
</head>

<body>
    <div class="page">
        <div class="header">
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/navigation.php'; ?>
        </div>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/sort.php'; ?>
        <div class="pageWrap">
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/categories.php'; ?>
            <div class="products">
                <?php
                $class = 'cartAdd';
                $text = 'Добавить в корзину';
                foreach ($products as $p) {
                    require $_SERVER['DOCUMENT_ROOT'] . '/views/product.php';
                }
                ?>
            </div>
        </div>
        <div class="navigation">
            <?= $pages; ?>
        </div>
        <div class="footer">
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/footer.php'; ?>
        </div>
    </div>
    <script src="/views/index.js"></script>
</body>

</html>