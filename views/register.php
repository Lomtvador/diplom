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
        </div>
        <div class="pageWrap">
            <form method="post" target="_blank">
                <label for="surname">Фамилия</label>
                <input type="text" name="surname" id="surname" required>
                <label for="name">Имя</label>
                <input type="text" name="name" id="name" required>
                <label for="patronymic">Отчество</label>
                <input type="text" name="patronymic" id="patronymic">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" required>
                <label for="birthday">Дата рождения</label>
                <input type="date" name="birthday" id="birthday" required>
                <label for="phoneNumber">Номер телефона</label>
                <input type="number" name="phoneNumber" id="phoneNumber" min="0" max="999999999999999" required>
                <label for="login">Логин</label>
                <input type="text" name="login" id="login" required>
                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" required>
                <label for="passwordConfirm">Подтверждение пароля</label>
                <input type="password" name="passwordConfirm" id="passwordConfirm" required>
                <input type="submit" value="Зарегистрироваться">
            </form>
        </div>
        <div class="footer">
            <?php require '../controllers/footer.php'; ?>
        </div>
    </div>
</body>

</html>