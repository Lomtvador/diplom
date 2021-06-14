<div class="navigation">
    <a class="navLink" href="/">
        <img class="logo" src="/images/logo.jpg">
        <div class="logoText">Главная страница</div>
    </a>
    <?php if (isset($_SESSION['id'])) { ?>
        <a class="navLink" href="/controllers/userPage.php">Личный кабинет</a>
    <?php } ?>
    <?php if (isset($_SESSION['id']) && $_SESSION['role'] !== 0) { ?>
        <a class="navLink" href="/controllers/cart.php">Корзина</a>
    <?php } ?>
    <?php if (isset($_SESSION['id']) && $_SESSION['role'] === 0) { ?>
        <a class="navLink" href="/controllers/admin.php">Администрирование</a>
    <?php } ?>
    <?php if (!isset($_SESSION['id'])) { ?>
        <a class="navLink" href="/controllers/register.php">Зарегистрироваться</a>
        <a class="navLink" href="/controllers/login.php">Войти</a>
    <?php } ?>
    <?php if (isset($_SESSION['id'])) { ?>
        <a class="navLink" href="/controllers/logout.php">Выйти</a>
    <?php } ?>
</div>