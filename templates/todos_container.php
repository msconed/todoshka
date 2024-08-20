<?php 


if (isset($_SESSION['AUTHORIZED_USERNAME'])) {
    
?>
<div class="toDo-main-container" id="toDo-main-container">
    <div class="toDo-child-container" id="toDo-child-container">
    <?php require_once __DIR__."/../fn/get_todos.php" ?>
    </div>
    <?php } ?>
</div>