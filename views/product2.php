<div class="product">
    <div class="imageWrap">
        <img class="image" src="<?= $p->imagePath ?>">
    </div>
    <div class="infoWrap">
        <div class="title"><?= $p->titleRussian ?></div>
        <img class="rating" src="<?= $p->rating ?>"> <br>
        <a class="download" href="/controllers/download.php?id=<?= $p->id ?>">Скачать</a>
    </div>
</div>