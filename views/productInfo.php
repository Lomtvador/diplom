<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/views/index.css">
    <link rel="stylesheet" href="/views/productInfo.css">
    <title>Магазин</title>
</head>

<body>
    <div class="page">
        <div class="header">
            <?php require 'navigation.php'; ?>
        </div>
        <div class="product">
            <div class="imageWrap">
                <img class="image" src="<?= $p->imagePath ?>">
            </div>
            <div class="info">
                Тип: <?= $p->type ?> <br>
                Количество страниц: <?= $p->pageCount ?> <br>
                Издатель: <?= $p->publisher ?> <br>
                Автор(ы): <?= $p->author ?> <br>
                Название на русском: <?= $p->titleRussian ?> <br>
                Оригинальное название: <?= $p->titleOriginal ?> <br>
                Художник(и): <?= $p->artist ?> <br>
                Дата выхода: <?= $p->publicationDate ?> <br>
                Возрастное ограничение: <?= $p->rating ?> <br>
                Цена: <?= $p->price[0] ?>,<?= $p->price[1] ?> ₽ <br>
                Краткое Описание: <?= $p->description ?> <br>
                Язык: <?= $p->language ?><br>
                Категория: <?= $p->category ?> <br>
            </div>
            <a class="cartAdd" href="/controllers/cartAdd.php?id=<?= $p->id ?>">Добавить в корзину</a>
        </div>
    </div>
</body>

</html>