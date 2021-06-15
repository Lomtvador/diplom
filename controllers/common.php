<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/message.php';
function isEmpty(&$obj)
{
    return !isset($obj) || trim($obj) === '';
}
function checkUser(&$obj, bool $checkEmpty = true)
{
    $namesForm = ['surname', 'name', 'email', 'birthday', 'phoneNumber', 'login', 'password', 'passwordConfirm'];
    $namesMessage = ['фамилия', 'имя', 'e-mail', 'дата рождения', 'контактный номер телефона', 'логин', 'пароль', 'подтверждение пароля'];
    if ($checkEmpty) {
        for ($i = 0; $i < count($namesForm); $i++) {
            if (!isset($obj[$namesForm[$i]]) || trim($obj[$namesForm[$i]]) === '') {
                $str = $namesMessage[$i];
                new Message("Не заполнено следующее поле: $str");
            }
        }
    }

    if (!isEmpty($obj['email']) && !filter_var($obj['email'], FILTER_VALIDATE_EMAIL)) {
        new Message('Введён неправильный e-mail: ' . $obj['email']);
    }

    if (!isEmpty($obj['birthday'])) {
        $d = DateTime::createFromFormat('Y-m-d', $obj['birthday']);
        if (!($d && $d->format('Y-m-d') == $obj['birthday'])) {
            new Message('Введена неправильная дата рождения: ' . $obj['birthday']);
        }
        $currentDay = new DateTime();
        $diff = $currentDay->diff($d);
        $age = $diff->y;
        if ($age < 14) {
            new Message('Покупки доступны только для лиц старше 14 лет');
        }
    }
    if (!isEmpty($obj['phoneNumber'])) {
        $obj['phoneNumber'] = intval($obj['phoneNumber']);
        $n = $obj['phoneNumber'];
        if (!(7_000_000_00_00 <= $n && $n <= 8_999_999_99_99)) {
            new Message('Длина контактного номера телефона должна быть равна 11 и первая цифра должна быть 7 или 8');
        }
    }
    if (isEmpty($obj['patronymic']))
        $obj['patronymic'] = '';
    if (isEmpty($obj['password']))
        $obj['password'] = '';
    else {
        $len = strlen($obj['password']);
        if (!(10 <= $len && $len <= 50)) {
            new Message('Длина пароля должна быть от 10 до 50 включительно');
        }
    }
    if (isEmpty($obj['passwordConfirm']))
        $obj['passwordConfirm'] = '';
    if (!isEmpty($obj['password']) || !isEmpty($obj['passwordConfirm'])) {
        if ($obj['password'] !== $obj['passwordConfirm']) {
            new Message('Пароли не совпадают');
        }
    }
}
function checkProduct(&$obj, bool $checkEmpty = true)
{
    $namesForm = ['pageCount', 'publisher', 'titleRussian', 'titleOriginal', 'author', 'artist', 'publicationDate', 'rating', 'price1', 'price2', 'description', 'language', 'category'];
    $namesMessage = ['количество страниц', 'издатель', 'название на русском языке', 'название на оригинальном языке', 'автор(ы)', 'художник(и)', 'дата выхода', 'возрастное ограничение', 'цена в рублях', 'цена в копейках', 'краткое описание', 'язык', 'категория'];
    if ($checkEmpty) {
        for ($i = 0; $i < count($namesForm); $i++) {
            if (!isset($obj[$namesForm[$i]]) || trim($obj[$namesForm[$i]]) === '') {
                $str = $namesMessage[$i];
                new Message("Не заполнено следующее поле: $str");
            }
        }
    }
    if (in_array($obj['category'], array('Фантастика', 'Боевик', 'Драма', 'Супергерои'))) {
        $obj['type'] = 1;
    } else if (in_array($obj['category'], array('Бизнес', 'Электроника', 'Путешествие и туризм', 'Наука'))) {
        $obj['type'] = 0;
    } else {
        new Message('Выбрана несуществующая категория: ' . $obj['category']);
    }
    if (!isEmpty($obj['pageCount'])) {
        $obj['pageCount'] = intval($obj['pageCount']);
        $d = DateTime::createFromFormat('Y-m-d', $obj['publicationDate']);
        if (!($d && $d->format('Y-m-d') == $obj['publicationDate'])) {
            new Message('Введена неправильная дата выхода: ' . $obj['publicationDate']);
        }
    }
    if (!isEmpty($obj['rating'])) {
        $obj['rating'] = intval($obj['rating']);
        if (!(0 <= $obj['rating'] && $obj['rating'] <= 4)) {
            new Message('Возрастное ограничение может быть только от 0 до 4 включительно');
        }
    }
    if (!isEmpty($obj['price1']) && !isEmpty($obj['price2'])) {
        $price = [];
        $price[0] = intval($_POST['price1']);
        $price[1] = intval($_POST['price2']);
        if (!(0 <= $price[0] && $price[0] <= 9_999_999_999)) {
            new Message('Рублей должно быть от 0 до 9 999 999 999 включительно');
        }
        if (!(0 <= $price[1] && $price[1] <= 99)) {
            new Message('Копеек должно быть от 0 до 99 включительно');
        }
        $obj['price'] = $price[0] . '.' . sprintf('%02d', $price[1]);
    }

    if ($checkEmpty && !isset($_FILES['image'])) {
        new Message('Не задана картинка товара');
    }

    if ($checkEmpty && !isset($_FILES['file'])) {
        new Message('Не задан файл товара');
    }

    $obj['hidden'] = isset($obj['hidden']);
}
