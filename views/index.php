<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/views/index.css">
    <title>Магазин</title>
</head>

<body>
    <div class="page">
        <div class="header">
            <?php require 'navigation.php'; ?>
        </div>
        <?php require 'sort.php'; ?>
        <div class="pageWrap">
            <?php require 'categories.php'; ?>
            <div class="products">
                <?php foreach ($products as $p) {
                    require 'product.php';
                }
                ?>
            </div>
        </div>
        <div class="navigation">
            <?= $pages; ?>
        </div>
        <div class="footer"></div>
    </div>
    <script src="/views/index.js"></script>
</body>

</html>