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
            <form method="post">
                <label for="login">Логин</label>
                <input type="text" name="login" id="login" required>
                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" required>
                <input type="submit" value="Войти">
            </form>
        </div>
        <div class="footer"></div>
    </div>
</body>

</html>