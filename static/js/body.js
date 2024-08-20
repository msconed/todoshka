
function handleRegistrationResponse(event) {
    const response = event.detail.xhr.response;

    try {
        const data = JSON.parse(response);

        if (data.status === 'error') {
            autolog.log(data.message, "error", 3000);
        } else if (data.status === 'success') {
            // Логика для успешной регистрации
            document.getElementById('modal').remove();
            autolog.log(data.message, "success", 6000);
        }
    } catch (e) {
        console.error("Ошибка при обработке ответа:", e);
    }
}


function handleAuthResponse(event) {
    const response = event.detail.xhr.response;

    try {
        const data = JSON.parse(response);

        if (data.status === 'error') {
            autolog.log(data.message, "error", 3000);
        } else if (data.status === 'success') {
            document.getElementById('modal').remove();
            autolog.log(data.message, "success", 6000);
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }
    } catch (e) {
        console.error("Ошибка при обработке ответа:", e);
    }
}

function handleLogoutResponse() {
    setTimeout(() => {
        window.location.reload();
    }, 500);
}


function handleNewToDoResponse(event) {
    const response = event.detail.xhr.response;

    try {
        const data = JSON.parse(response);

        if (data.status === 'error') {
            autolog.log(data.message, "error", 3000);
        } else if (data.status === 'success') {
            document.getElementById('modal').remove();
            autolog.log(data.message, "success", 6000);
            updateToDoList();
        }
    } catch (e) {
        console.error("Ошибка при обработке ответа:", e);
    }
}


function handleTodoDelResponse(event) {
    const response = event.detail.xhr.response;

    try {
        const data = JSON.parse(response);

        if (data.status === 'error') {
            autolog.log(data.message, "error", 3000);
        } else if (data.status === 'success') {
            autolog.log(data.message, "success", 6000);
            updateToDoList()
        }
    } catch (e) {
        console.error("Ошибка при обработке ответа:", e);
    }
}

function handleTodoEditResponse(event) {
    const response = event.detail.xhr.response;

    try {
        const data = JSON.parse(response);

        if (data.status === 'error') {
            autolog.log(data.message, "error", 3000);
        } else if (data.status === 'success') {
            document.getElementById('modal').remove();
            autolog.log(data.message, "success", 6000);
            updateToDoList()
        }
    } catch (e) {
        console.error("Ошибка при обработке ответа:", e);
    }
}

function updateToDoList() {
    htmx.ajax('GET', '../fn/get_todos.php', {
        target: '#toDo-child-container',
        swap: 'innerHTML'
    });
}