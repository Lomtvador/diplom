<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common.php';
$ratings = [0, 6, 12, 16, 18];
$rating = $ratings[$p->rating] . '+';
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/views/common.css">
    <link rel="stylesheet" href="/views/productInfo.css">
    <title>Магазин</title>
</head>

<body>
    <div class="page">
        <div class="header">
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/navigation.php'; ?>
        </div>
        <div class="product">
            <div class="imageWrap">
                <img class="image" src="<?= $p->imagePath ?>">
            </div>
            <div class="info">
                <?php if (isset($_SESSION['id']) && $_SESSION['role'] === 0) { ?>
                    Идентификатор: <?= $p->id ?> <br>
                <?php } ?>
                Тип: <?= $p->type ?> <br>
                Количество страниц: <?= $p->pageCount ?> <br>
                Издатель: <?= $p->publisher ?> <br>
                Автор(ы): <?= $p->author ?> <br>
                Название на русском: <?= $p->titleRussian ?> <br>
                Оригинальное название: <?= $p->titleOriginal ?> <br>
                Художник(и): <?= $p->artist ?> <br>
                Дата выхода: <?= $p->publicationDate ?> <br>
                Возрастное ограничение: <?= $rating ?> <br>
                Цена: <?= formatPrice($p->price) ?> <br>
                Краткое Описание: <?= $p->description ?> <br>
                Язык: <?= $p->language ?><br>
                Категория: <?= $p->category ?> <br>
            </div>
            <?php if (isset($_SESSION['id']) && $_SESSION['role'] !== 0) { ?>
                <a class="cartAdd" href="/controllers/cartAdd.php?id=<?= $p->id ?>">Добавить в корзину</a>
            <?php } ?>
        </div>
        <div class="footer">
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/footer.php'; ?>
        </div>
    </div>
</body>

</html>