<?php

require __DIR__."/db.php";
session_start();

if ( !(isset( $_SESSION[ 'checks-request' ] ) && $_SESSION[ 'checks-request' ] === TRUE ) )  {
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? "-1";

    if (strlen($name) == 0) {echo ""; exit();}

    if (!username_validation(htmlspecialchars($name))) 
    {echo "<div style='color:red;font-size:12px;'>Имя может содержать только буквы и цифры</div>"; exit();} else {
        echo "";
    }

    $check = check_username(htmlspecialchars($name));
    if ($check)
    {
        echo "<div style='color:red'>Имя уже занято!</div>";
    } else
    {
        echo "";
    }
}
