<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Магазин</title>
    <link rel="stylesheet" href="/views/common.css">
    <link rel="stylesheet" href="/views/form.css">
</head>

<body>
    <div class="page">
        <div class="header">
            <?php require 'navigation.php'; ?>
            <?php require 'adminNavigation.php'; ?>
        </div>
        <div class="pageWrap">
            <form method="post" enctype="multipart/form-data">
                <label for="pageCount">Количество страниц</label>
                <input type="number" name="pageCount" id="pageCount" required>
                <label for="publisher">Издатель</label>
                <input type="text" name="publisher" id="publisher" required>
                <label for="titleRussian">Название на русском языке</label>
                <input type="text" name="titleRussian" id="titleRussian" required>
                <label for="titleOriginal">Название на оригинальном языке</label>
                <input type="text" name="titleOriginal" id="titleOriginal" required>
                <label for="author">Автор(ы)</label>
                <input type="text" name="author" id="author" required>
                <label for="artist">Художник(и)</label>
                <input type="text" name="artist" id="artist" required>
                <label for="publicationDate">Дата выхода</label>
                <input type="date" name="publicationDate" id="publicationDate" required>
                <label for="rating">Возрастное ограничение</label>
                <select name="rating" id="rating">
                    <option value="0">0+</option>
                    <option value="1">6+</option>
                    <option value="2">12+</option>
                    <option value="3">16+</option>
                    <option value="4">18+</option>
                </select>
                <label for="price1">Цена в рублях</label>
                <input type="number" name="price1" id="price1" min="0" max="9999999999" step="1" required>
                <label for="price2">Цена в копейках</label>
                <input type="number" name="price2" id="price2" min="0" max="99" step="1" required>
                <label for="description">Краткое описание</label>
                <input type="text" name="description" id="description" required>
                <label for="language">Язык</label>
                <input type="text" name="language" id="language" required>
                <label for="category">Категория</label>
                <select name="category" id="category">
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
                <input type="file" name="image" id="image" required>
                <label for="file">Файл с продуктом</label>
                <input type="file" name="file" id="file" required>
                <label for="hidden">Продукт скрыт от покупателей</label>
                <input type="checkbox" name="hidden" id="hidden">
                <input type="submit" value="Добавить">
            </form>
        </div>
        <div class="footer"></div>
    </div>
</body>

</html>