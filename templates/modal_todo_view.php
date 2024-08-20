
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    session_start();
    $header_text    = $_POST['header_text'] ?? null;
    $text           = $_POST['text'] ?? null;

    $headers = getallheaders();
    $token          = $headers['X-CSRFToken'] ?? null;
    $token_session  = $_SESSION['csrf_token'] ?? null;
    $username       = $_SESSION['AUTHORIZED_USERNAME'] ?? null;
    if (
        !(isset($_SESSION['checks-request']) && $_SESSION['checks-request'] === TRUE)
         OR (is_null($token) or (is_null($token_session)))
         OR $token !== $token_session
         OR (is_null($header_text) or is_null($text))
        ) 
         
    {
        http_response_code(403);
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized request']);
        exit();
    }
?>
<div id="modal" _="on closeModal add .closing then wait for animationend then remove me">
    <div class="modal-underlay" _="on click trigger closeModal"></div>
    <div class="modal-content-auth">
        <div class="form">
            <p id="heading">Просмотр</p>

        <div class="form-container">
            <div class="form">
                <div class="form-group">
                <label for="email">Заголовок</label>
                <input type="text"name="ToDo-header" autocomplete="off" value="<?php echo $header_text ?>">
                </div>
                <div class="form-group">
                <label for="textarea">Текст</label>
                <textarea name="ToDo-text" rows="10" cols="50"><?php echo $text ?></textarea>
                </div>
                <button class="form-submit-btn"  _="on click trigger closeModal">Закрыть</button>
            </div>
            </div>

        </div>
    </div>
</div>


<?php } ?>