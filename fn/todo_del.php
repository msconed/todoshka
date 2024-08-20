<?php
require __DIR__ . "/db.php";
session_start();
$headers = getallheaders();
$token          = $headers['X-CSRFToken'] ?? null;
$token_session  = $_SESSION['csrf_token'] ?? null;
if (!(isset($_SESSION['checks-request']) && $_SESSION['checks-request'] === TRUE) OR (is_null($token) or (is_null($token_session))) OR $token !== $token_session) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized request']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['AUTHORIZED_USERNAME'] ?? null;
    $todo_id = $_POST['id'] ?? null;

    if ((is_null($username) or is_null($todo_id))) {
        echo json_encode(['status' => 'error', 'message' => 'Произошла ошибка при попытке удаления']);
        exit();
    }

    $successDel = delTodo($todo_id);


    if ($successDel) 
    {
        echo json_encode(['status' => 'success', 'message' => 'Запись удалена!']);
        
    } else 
    {
        echo json_encode(['status' => 'error', 'message' => 'Произошла ошибка, попробуйте позже...']);
    }
    exit();
}
