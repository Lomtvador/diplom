<?php
require_once 'message.php';
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
    }
    if (!isEmpty($obj['phoneNumber'])) {
        $obj['phoneNumber'] = intval($obj['phoneNumber']);
        $n = $obj['phoneNumber'];
        if (!(7_000_000_00_00 <= $n && $n <= 8_999_999_99_99)) {
            new Message('Длина контактного номера телефона должна быть равна 11 и первая цифра должна быть 7 или 8');
        }
    }
    if (!isEmpty($obj['password']) && !isEmpty($obj['passwordConfirm'])) {
        if ($obj['password'] !== $obj['passwordConfirm']) {
            new Message('Пароли не совпадают');
        }
    }
}
