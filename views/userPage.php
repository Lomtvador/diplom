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
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/navigation.php'; ?>
        </div>
        <div class="pageWrap">
            <div class="userEdit">
                <h2>Редактировать данные</h2>
                <button>Показать</button>
                <form method="post">
                    <h2>Идентификатор: <?= $u->id ?></h2>
                    <div>
                        <label for="surname">Фамилия</label>
                        <input type="text" name="surname" id="surname" value="<?= $u->surname ?>">
                        <label for="name">Имя</label>
                        <input type="text" name="name" id="name" value="<?= $u->name ?>">
                        <label for="patronymic">Отчество</label>
                        <input type="text" name="patronymic" id="patronymic" value="<?= $u->patronymic ?>">
                    </div>
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" value="<?= $u->email ?>">
                    <label for="birthday">Дата рождения</label>
                    <input type="date" name="birthday" id="birthday" value="<?= $u->birthday ?>">
                    <label for="phoneNumber">Номер телефона</label>
                    <input type="number" name="phoneNumber" id="phoneNumber" min="0" max="999999999999999" value="<?= $u->phoneNumber ?>">
                    <div>
                        <label for="login">Логин</label>
                        <input type="text" name="login" id="login" value="<?= $u->login ?>" readonly onfocus="this.removeAttribute('readonly')">
                        <label for="password">Пароль</label>
                        <input type="password" name="password" id="password" readonly onfocus="this.removeAttribute('readonly')">
                        <label for="passwordConfirm">Подтверждение пароля</label>
                        <input type="password" name="passwordConfirm" id="passwordConfirm" readonly onfocus="this.removeAttribute('readonly')">
                    </div>
                    <input type="submit" value="Обновить">
                </form>
            </div>
            <h2>Продукты</h2>
            <div class="products">
                <?php
                foreach ($products as $p) {
                    require $_SERVER['DOCUMENT_ROOT'] . '/views/product2.php';
                }
                ?>
            </div>
        </div>
        <div class="footer">
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/footer.php'; ?>
        </div>
    </div>
    <script src="/views/userPage.js"></script>
</body>

</html>