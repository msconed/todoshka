<?php
require_once __DIR__ . "/db.php";
if (session_status() === PHP_SESSION_NONE) {
    // Если сессия не запущена, запускаем её
    session_start();
}
$token = $_SESSION['csrf_token'];
$username = $_SESSION['AUTHORIZED_USERNAME'] ?? null;

if (is_null($username) or is_null($token)) {

    exit();
}
$todos = getTodos($username);

foreach ($todos as $ar)
{
    $id = $ar['id'];
    $header = htmlspecialchars($ar['header']);
    $text = htmlspecialchars($ar['text']);
    echo <<<EOT
            <div class="card">
                <span>$header</span>
                <p class="info">
                    $text
                </p>
                <div style="display: flex;">
                    <button
                        hx-post="templates/modal_todo_view.php" hx-trigger="click" hx-boost="true" hx-target="body" 
                        hx-headers='{"X-Requested-With": "XMLHttpRequest", "X-CSRFToken": "$token"}'
                        hx-swap="beforeend"
                        hx-vals='{"header_text": "$header", "text": "$text"}'
                    >
                        <div class="svg-icon-view" title="Посмотреть"></div>
                    </button>
                    <button
                        hx-post="templates/modal_edit.php" hx-trigger="click" hx-boost="true" hx-target="body" 
                        hx-headers='{"X-Requested-With": "XMLHttpRequest", "X-CSRFToken": "$token"}'
                        hx-swap="beforeend"
                        hx-vals='{"id": $id, "header_text": "$header", "text": "$text"}'
                    >
                        <div class="svg-icon-edit" title="Редактировать"></div>
                    </button>
                    <button
                        hx-post="../fn/todo_del.php" hx-trigger="click" hx-boost="true" hx-on="htmx:afterRequest: handleTodoDelResponse(event)"
                        hx-headers='{"X-Requested-With": "XMLHttpRequest", "X-CSRFToken": "$token"}'
                        hx-swap="none"
                        hx-vals='{"id": $id}'
                    >
                        <div class="svg-icon-delete" title="Удалить"></div>
                    </button>
                </div>
            </div>
    EOT;
}



