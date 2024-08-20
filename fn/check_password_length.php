<?php

require __DIR__."/db.php";
session_start();

if ( !(isset( $_SESSION[ 'checks-request' ] ) && $_SESSION[ 'checks-request' ] === TRUE ) )  {
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pass = htmlspecialchars($_POST['password']) ?? null;
    switch (true) {
        case $pass === null:
            break;
        case strlen($pass) < 5:
            echo "<div style='color:red'>Пароль слишком короткий</div>";
        default:
            echo "";
    }
}
