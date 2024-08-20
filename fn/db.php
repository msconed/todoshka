<?php 

class Database
{
    
    private ?string $hostname;
    private ?string $username;
    private ?string $password;
    private ?string $database;
    private $mysqli;
    
    function __construct() {
        $this->hostname = "localhost";
        $this->username = "phpAdmin";
        $this->password = "123";
        $this->database = "php_test_3";
    }
    public function __destruct() {
        $this->mysqli->close();
    }


    function connect()
    {
        $this->mysqli = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        $this->mysqli->autocommit(true);
    }

    function query($mode, $args=[])
    {
        if (!isset($this->mysqli))
        { $this->connect(); }
        
        switch ($mode) {
                case "check-username": // Проверка существования username        
                $stmt = $this->mysqli->prepare("SELECT name FROM users WHERE name=?");
                $stmt->bind_param("s", $args['name']);
                $stmt->execute();
                $result = $stmt->get_result();
                $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
                return count($result) > 0;

                case "registration": // Регистрация
                    $success = false;
                    $hashed_password = password_hash($args['pass'], PASSWORD_DEFAULT);  
                    $stmt = $this->mysqli->prepare("INSERT INTO users (name, pass) VALUES (?, ?)");
                    $stmt->bind_param("ss", $args['name'], $hashed_password);
                    if ($stmt->execute()) { // Если запрос выполнен успешно
                        $success = true;
                    }
                    return $success;


                case "check-auth": // Авторизация
                    $success = false;
                    $hashed_password = password_hash($args['pass'], PASSWORD_DEFAULT);  
                    $stmt = $this->mysqli->prepare("SELECT pass FROM users WHERE name = ?");
                    $stmt->bind_param("s", $args['name']);
                    if ($stmt->execute()) {
                        $result = $stmt->get_result();
                        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        $db_hash = $result[0]['pass'];
                        if (password_verify($args['pass'], $db_hash)) {$success=true;}
                    }
                    return $success;

                case "add-newTodo": // Авторизация
                    $author = $args['user'];
                    $header = $args['header'];
                    $text = $args['text'];
                    $success = false;
                    $stmt = $this->mysqli->prepare("INSERT INTO todoshki (author, header, text) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $author, $header, $text);
                    if ($stmt->execute()) {
                        $success=true;
                    }
                    return $success;


                case "get-user-todos": // Авторизация
                    $author = $args['user'];
                    $result = [];
                    $stmt = $this->mysqli->prepare("SELECT * FROM todoshki WHERE author = ?");
                    $stmt->bind_param("s", $author);
                    if ($stmt->execute()) {
                        $result = $stmt->get_result();
                        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    }
                    return $result;


                case "del-user-todo": // Удаление ToDO
                    $id     = $args['todo_id'];
                    
                    $success = false;
                    $stmt = $this->mysqli->prepare("DELETE FROM todoshki WHERE id=?");
                    $stmt->bind_param("i", $id);
                    if ($stmt->execute()) {
                        $success=true;
                    }
                    return $success;       
                    
                case "edit-todo": // Редактирование ToDo
                    $author = $args['user'];
                    $header = $args['header'];
                    $text = $args['text'];
                    $id = $args['id'];
                    $success = false;
                    $stmt = $this->mysqli->prepare("UPDATE todoshki SET header=?, text=? WHERE author=? AND id=?");
                    $stmt->bind_param("sssi",  $header, $text, $author, $id);
                    if ($stmt->execute()) {
                        $success=true;
                    }
                    return $success;
        }
    }
}

function editTodo($username, $header, $text, $id)
{
    $db = new Database();
    $success = $db->query("edit-todo", ['user'=>$username, 'header'=>$header, 'text'=>$text, 'id'=>$id]);
    return $success;
}




function delTodo($todo_id)
{
    $db = new Database();
    $todoDelete = $db->query("del-user-todo", ['todo_id'=>$todo_id]);
    return $todoDelete;
}



function registration($name, $pass) 
{
    /* Перепроверяем имя */
    $alreadyCreatedName = check_username($name);
    if ($alreadyCreatedName) {return false;}
    $db = new Database();
    $created = $db->query("registration", ['name'=>$name, 'pass'=>$pass]);
    return $created;
}


function check_username($name) 
{
    if ($name === "-1") {return true;}
    $db = new Database();
    $created = $db->query("check-username", ['name'=>$name]);
    return $created;
}

function check_auth($name, $pass) 
{
    $db = new Database();
    $success = $db->query("check-auth", ['name'=>$name, 'pass'=>$pass]);
    return $success;
}

function username_validation($username)
{
    return ctype_alnum($username);
}


function newTodo($user, $header, $text)
{
    $db = new Database();
    $success = $db->query("add-newTodo", ['user'=>$user, 'header'=>$header, 'text'=>$text]);
    return $success;
}


function getTodos($author)
{
    $db = new Database();
    $todosArray = $db->query("get-user-todos", ['user'=>$author]);
    return $todosArray;
}





