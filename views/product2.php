<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common.php';
$ratings = [0, 6, 12, 16, 18];
$ratingImg = '/images/rating/' . $ratings[$p->rating] . '.png';
?>
<div class="product">
    <div class="imageWrap">
        <img class="image" src="<?= $p->imagePath ?>">
    </div>
    <div class="infoWrap">
        <div class="title"><?= $p->titleRussian ?></div>
        <img class="rating" src="<?= $ratingImg ?>"> <br>
        <a class="download" href="/controllers/download.php?id=<?= $p->id ?>">Скачать</a>
    </div>
</div>