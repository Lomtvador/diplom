<?php
// [1975, 4] -> formatPrice -> 1 975,04 ₽
function formatPrice($price)
{
    $str = number_format($price[0], 0, '', ' ');
    $str .= ',';
    $str .= sprintf('%02d', $price[1]);
    $str .= ' ₽';
    return $str;
}
