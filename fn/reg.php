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

    if ((is_null($name) or is_null($password)) or (strlen($name) === 0 or strlen($password) < 5) or !username_validation(htmlspecialchars($name))) {
        echo json_encode(['status' => 'error', 'message' => 'Некорректный ввод данных']);
        exit();
    }

    $successRegistration = registration(htmlspecialchars($name), htmlspecialchars($password));
    header('Content-Type: application/json');

    if ($successRegistration) 
    {
        echo json_encode(['status' => 'success', 'message' => 'Регистрация успешна']);
    } else 
    {
        echo json_encode(['status' => 'error', 'message' => 'Ошибка при регистрации']);
    }
    exit();
}
