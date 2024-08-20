<?php
require __DIR__ . "/db.php";
session_start();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $headers = getallheaders();
    $token          = $headers['X-CSRFToken'] ?? null;
    $token_session  = $_SESSION['csrf_token'] ?? null;
    $username = $_SESSION['AUTHORIZED_USERNAME'] ?? null;
    if (!(isset($_SESSION['checks-request']) && $_SESSION['checks-request'] === TRUE) OR (is_null($token) or (is_null($token_session))) OR $token !== $token_session or is_null($username)) {
        http_response_code(403);
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized request']);
        exit();
    }

    $header = $_POST['ToDo-header'] ?? null;
    $text = $_POST['ToDo-text'] ?? null;

    if (is_null($header) or strlen($header) === 0 or strlen($text) === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Заполните все поля']);
        exit();
    }

    $successSaveTodo = newTodo($username, $header, $text);

    if ($successSaveTodo) 
    {
        echo json_encode(['status' => 'success', 'message' => 'Ваша запись успешно сохранена']);
    } else 
    {
        echo json_encode(['status' => 'error', 'message' => 'Произошла ошибка, попробуйте позже...']);
    }
    exit();
}
