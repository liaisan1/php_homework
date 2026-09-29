<?php

$name = "";
$age = "";
$email = "";

$nameError = "";
$ageError = "";
$emailError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $age = $_POST["age"];
    $email = $_POST["email"];

    if ($name == "") {
        $nameError = "Введите имя";
    }

    if ($age == "") {
        $ageError = "Введите возраст";
    } elseif (!is_numeric($age)) {
        $ageError = "Возраст должен быть числом";
    } elseif ($age != (int)$age) {
        $ageError = "Возраст должен быть целым числом";
    } elseif ($age < 1 || $age > 120) {
        $ageError = "Возраст должен быть от 1 до 120";
    }

    if ($email == "") {
        $emailError = "Введите email";
    } elseif (strpos($email, "@") == false) {
        $emailError = "Email должен содержать @";
    }

    if ($nameError == "" && $ageError == "" && $emailError == "") {
        echo "Добро пожаловать, " . $name . "! ";
        echo "Ваш возраст: " . $age . ", email: " . $email;
        exit;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Форма</title>
</head>

<body>

<form method="POST">

    Имя:
    <input type="text" name="name" value="<?= $name ?>">
    <br>
    <?= $nameError ?>

    <br><br>

    Возраст:
    <input type="text" name="age" value="<?= $age ?>">
    <br>
    <?= $ageError ?>

    <br><br>

    Email:
    <input type="text" name="email" value="<?= $email ?>">
    <br>
    <?= $emailError ?>

    <br><br>

    <input type="submit" value="Отправить">

</form>

</body>
</html>