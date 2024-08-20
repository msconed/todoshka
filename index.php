<!DOCTYPE html>
<html lang="en">

<?php require_once __DIR__."/templates/head.php" ?>
<?php require_once __DIR__."/fn/db.php" ?>
<?php 

    /*
        Переменная для проверки запросов на регистрацию и авторизацию
        Если попытка регистрации или авторизации извне - запрос отклоняем
    */
    session_start();
    $_SESSION['checks-request'] = true;
    $_SESSION['csrf_token'] = strval(bin2hex(random_bytes(35)));


?>


<body>
    <div class="main">
        <video autoplay loop class="_WelcomeVideo_6b9b7_1">
            <source src="/static/video/NatureBack-CpLZG4Tx.mp4">
        </video>

        <?php require_once __DIR__."/templates/header.php" ?>
        <?php require_once __DIR__."/templates/todos_container.php" ?>

        <div id="toasts" style="position: fixed; z-index: 9999; inset: 16px; pointer-events: none;"></div>
    </div>
    <script src="static/js/body.js"></script>
</body>

</html>