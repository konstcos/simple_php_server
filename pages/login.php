<?php

$data = $postData;

$userData = (array)$data['user_data'];

$userId = $userData['id'];
$email = isset($userData['email']) ? $userData['email'] : '';
$name = isset($userData['name']) ? $userData['name'] : '';
$watchedVideosFromServer = (array)$data['watched_videos'];
$faceBookToken = isset($data['face_book_token']) ? (string)$data['face_book_token'] : false;



if (strlen(trim($userId)) === 0) {
    header('Content-type: application/json');
    echo json_encode(['status' => 'fail', 'info' => 'empty_data']);
    exit();
}

$today = date("Y-m-d H:i:s");

$sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";

$isAdmin = false;

if ($result = $mysqli->query($sql)) {

    $watchedVideos = [];

    if ($result->num_rows === 0) {

        $watchedVideos = json_encode($watchedVideosFromServer);

        $sql = "INSERT INTO users (user_facebook_api_id, email, `name`, watched_videos, updated_at) VALUES ('$userId', '$email', '$name', '$watchedVideos', '$today')";

    } else {

        $row = $result->fetch_assoc();

        $row = (array)$row;

        if ($row['watched_videos']) {
            $watchedVideos = (array)json_decode($row['watched_videos']);
        }

        foreach ($watchedVideosFromServer as $videoId => $videoStatus) {
            $watchedVideos[$videoId] = true;
        }

        $watchedVideosJson = $watchedVideos;

        $watchedVideos = json_encode($watchedVideos);

        $sql = "UPDATE users SET `name`='$name', watched_videos='$watchedVideos', email='$email', updated_at='$today'  WHERE user_facebook_api_id='$userId'";

        // проверка пользователя на админа
        if ($row['is_admin']) {
            // если пользователь админ

            // проверка токена пользователя
            $isAdmin = checkFaceBookToken($faceBookToken, $userId, $faceBookAppId);
        }
    }

    $mysqli->query($sql);

    $result->close();

    addUserToSendMsg($email, $name);
}


$mysqli->close();

header('Content-type: application/json');
echo json_encode([
    'status' => 'success',
    'watched_videos' => $watchedVideosJson,
    'is_admin' => $isAdmin,
]);
