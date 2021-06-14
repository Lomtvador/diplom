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
            <?php require 'adminNavigation.php'; ?>
        </div>
        <div class="pageWrap">
            <form method="post" enctype="multipart/form-data">
                <label for="id">Идентификатор</label>
                <input type="number" name="id" id="id" value="<?= $p->id ?>">
                <input type="submit" name="submitId" value="Подтвердить">
                <label for="pageCount">Количество страниц</label>
                <input type="number" name="pageCount" id="pageCount" value="<?= $p->pageCount ?>">
                <label for="publisher">Издатель</label>
                <input type="text" name="publisher" id="publisher" value="<?= $p->publisher ?>">
                <label for="titleRussian">Название на русском языке</label>
                <input type="text" name="titleRussian" id="titleRussian" value="<?= $p->titleRussian ?>">
                <label for="titleOriginal">Название на оригинальном языке</label>
                <input type="text" name="titleOriginal" id="titleOriginal" value="<?= $p->titleOriginal ?>">
                <label for="author">Автор(ы)</label>
                <input type="text" name="author" id="author" value="<?= $p->author ?>">
                <label for="artist">Художник(и)</label>
                <input type="text" name="artist" id="artist" value="<?= $p->artist ?>">
                <label for="publicationDate">Дата выхода</label>
                <input type="date" name="publicationDate" id="publicationDate" value="<?= $p->publicationDate ?>">
                <label for="rating">Возрастное ограничение</label>
                <select name="rating" id="rating" data-value="<?= $p->rating ?>">
                    <option value="0">0+</option>
                    <option value="1">6+</option>
                    <option value="2">12+</option>
                    <option value="3">16+</option>
                    <option value="4">18+</option>
                </select>
                <label for="price1">Цена в рублях</label>
                <input type="number" name="price1" id="price1" min="0" max="9999999999" step="1" value="<?= $p->price[0] ?>">
                <label for="price2">Цена в копейках</label>
                <input type="number" name="price2" id="price2" min="0" max="99" step="1" value="<?= $p->price[1] ?>">
                <label for="description">Краткое описание</label>
                <input type="text" name="description" id="description" value="<?= $p->description ?>">
                <label for="language">Язык</label>
                <input type="text" name="language" id="language" value="<?= $p->language ?>">
                <label for="category">Категория</label>
                <select name="category" id="category" data-value="<?= $p->category ?>">
                    <optgroup label="Журналы">
                        <option value="Бизнес">Бизнес</option>
                        <option value="Электроника">Электроника</option>
                        <option value="Путешествие и туризм">Путешествие и туризм</option>
                        <option value="Наука">Наука</option>
                    </optgroup>
                    <optgroup label="Комиксы">
                        <option value="Фантастика">Фантастика</option>
                        <option value="Боевик">Боевик</option>
                        <option value="Драма">Драма</option>
                        <option value="Супергерои">Супергерои</option>
                    </optgroup>
                </select>
                <label for="image">Изображение</label>
                <input type="file" name="image" id="image">
                <label for="file">Файл с продуктом</label>
                <input type="file" name="file" id="file">
                <label for="hidden">Продукт скрыт от покупателей</label>
                <input type="checkbox" name="hidden" id="hidden" <?= $p->hidden ? 'checked' : '' ?>>
                <input type="submit" name="submitProduct" value="Обновить">
            </form>
        </div>
        <div class="footer"></div>
    </div>
    <script src="/views/adminProducts.js"></script>
</body>

</html>