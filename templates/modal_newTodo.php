<div id="modal" _="on closeModal add .closing then wait for animationend then remove me">
    <div class="modal-underlay" _="on click trigger closeModal"></div>
    <div class="modal-content-auth">
        <div class="form">
            <p id="heading">Новая запись</p>

            
        <div class="form-container">
            <div class="form">
                <div class="form-group">
                <label for="email">Заголовок</label>
                <input type="text"name="ToDo-header" autocomplete="off">
                </div>
                <div class="form-group">
                <label for="textarea">Описание</label>
                <textarea name="ToDo-text" rows="10" cols="50"></textarea>
                </div>
                <button 
                    hx-include="[name='ToDo-header'], [name='ToDo-text']" 
                    hx-post="../fn/save_newTodo.php" 
                    hx-swap="none" 
                    hx-headers='{"X-Requested-With": "XMLHttpRequest", "X-CSRFToken": "<?php session_start();echo $_SESSION['csrf_token'] ?>"}'
                    hx-on="htmx:afterRequest: handleNewToDoResponse(event)"
                class="form-submit-btn">Сохранить</button>
            </div>
            </div>

        </div>
    </div>
</div>