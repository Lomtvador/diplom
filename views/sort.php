<div class="navigation">
    <?php foreach ($links as $a) { ?>
        <a class="navLink" href="?sort=<?= $a['sort'] ?>&asc=<?= intval(!$a['asc']) ?>&category=<?= $a['category'] ?>"><?= $a['text']; ?> <?= ($a['asc']) ?  '↓' : '↑' ?></a>
    <?php } ?>
</div>