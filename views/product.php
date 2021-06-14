<?php require_once 'common.php'; ?>
<div class="product">
    <div class="imageWrap">
        <img class="image" src="<?= $p->imagePath ?>">
    </div>
    <div class="infoWrap">
        <div class="title"><?= $p->titleRussian ?></div>
        <img class="rating" src="<?= $p->rating ?>">
        <div class="publicationDate"><?= $p->publicationDate ?></div>
        <div class="category"><?= $p->category ?></div>
        <div class="price"><?= formatPrice($p->price) ?></div>
        <a class="<?= $p->a6 ?>" href="<?= $p->a7 ?>"><?= $p->a8 ?></a>
        <a class="productInfo" href="<?= $p->a9 ?>">Подробнее</a>
    </div>
</div>