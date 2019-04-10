<?php
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
}

// проверка get запроса
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // если запрос get,
    // выходим
    echo('OK');
    exit();
}

// переменная с путем редиректа
$request = $_SERVER['REDIRECT_URL'];
// данные post
$postData = (array)json_decode(file_get_contents("php://input"));
// подключение настроек
require_once './settings.php';
require_once './src/functions.php';

// проверка отключения апликации
if (!$isAppOn) {
    header('Content-type: application/json');
    echo json_encode([
        'status' => 'fail',
        'info' => 'blocked',
    ]);
    exit();
}

// инициация БД
$mysqli = new mysqli($servername, $username, $password, $dbName);

switch ($request) {

    case '/login' :
        require __DIR__ . '/pages/login.php';
        break;

    case '/save_videos' :
        require __DIR__ . '/pages/save_videos.php';
        break;

    case '/get/watched/videos' :
        require __DIR__ . '/pages/get_videos.php';
        break;

    case '/get/check/lock' :
        require __DIR__ . '/pages/lock_check.php';
        break;

    case '/log' :
        require __DIR__ . '/pages/log.php';
        break;

    case '/send/message' :
        require __DIR__ . '/pages/send_messages.php';
        break;

    case '/send/registered/users' :
        require __DIR__ . '/pages/send_registered_users.php';
        break;

    default:
        require __DIR__ . '/pages/error.php';
        break;
}
