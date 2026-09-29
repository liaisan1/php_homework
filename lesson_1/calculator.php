<?php

echo "Введите первое число: ";
$a = fgets(STDIN);

echo "Введите второе число: ";
$b = fgets(STDIN);

echo "Введите оператор (+, -, *, /): ";
$operator = trim(fgets(STDIN));

if ($operator == "+") {
    echo $a + $b;
} elseif ($operator == "-") {
    echo $a - $b;
} elseif ($operator == "*") {
    echo $a * $b;
} elseif ($operator == "/") {
    if ($b == 0) {
        echo "Ошибка: деление на ноль";
    } else {
        echo $a / $b;
    }
} else {
    echo "Ошибка: неверный оператор";
}