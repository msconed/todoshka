<?php
require __DIR__ . "/db.php";
session_start();

if (!(isset($_SESSION['checks-request']) && $_SESSION['checks-request'] === TRUE)) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized request']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? null;
    $password = $_POST['password'] ?? null;

    if ((is_null($name) or is_null($password)) or (strlen($name) === 0 or strlen($password) < 5)) {
        echo json_encode(['status' => 'error', 'message' => 'Некорректный ввод данных']);
        exit();
    }

    $authorized = check_auth(htmlspecialchars($name), htmlspecialchars($password));
    header('Content-Type: application/json');

    if ($authorized) 
    {
        $_SESSION['AUTHORIZED_USERNAME'] = htmlspecialchars($name);
        echo json_encode(['status' => 'success', 'message' => 'Авторизация успешна']);
    } else 
    {
        echo json_encode(['status' => 'error', 'message' => 'Ошибка при авторизации']);
    }
    exit();
}
