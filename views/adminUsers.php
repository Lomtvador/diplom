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
            <form method="post">
                <label for="login">Логин</label>
                <input type="text" name="login" id="login" value="<?= $u->login ?>" readonly onfocus="this.removeAttribute('readonly')">
                <input type="submit" name="submitLogin" value="Подтвердить">
                <label for="id">Идентификатор</label>
                <input type="number" name="id" id="id" value="<?= $u->id ?>">
                <label for="surname">Фамилия</label>
                <input type="text" name="surname" id="surname" value="<?= $u->surname ?>">
                <label for="name">Имя</label>
                <input type="text" name="name" id="name" value="<?= $u->name ?>">
                <label for="patronymic">Отчество</label>
                <input type="text" name="patronymic" id="patronymic" value="<?= $u->patronymic ?>">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" value="<?= $u->email ?>">
                <label for="birthday">Дата рождения</label>
                <input type="date" name="birthday" id="birthday" value="<?= $u->birthday ?>">
                <label for="phoneNumber">Номер телефона</label>
                <input type="number" name="phoneNumber" id="phoneNumber" min="0" max="999999999999999" value="<?= $u->phoneNumber ?>">
                <input type="submit" name="submitUser" value="Обновить">
            </form>
        </div>
        <div class="footer"></div>
    </div>
</body>

</html>