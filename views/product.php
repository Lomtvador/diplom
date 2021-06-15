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
        <img class="rating" src="<?= $ratingImg ?>">
        <div class="publicationDate"><?= $p->publicationDate ?></div>
        <div class="category"><?= $p->category ?></div>
        <div class="price"><?= formatPrice($p->price) ?></div>
        <?php if (isset($_SESSION['id']) && $_SESSION['role'] !== 0) { ?>
            <a class="<?= $class ?>" href="/controllers/<?= $class ?>.php?id=<?= $p->id ?>"><?= $text ?></a>
        <?php } ?>
        <a class="productInfo" href="/controllers/productInfo.php?id=<?= $p->id ?>">Подробнее</a>
    </div>
</div>