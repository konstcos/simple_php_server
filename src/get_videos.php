<?php


$data = (array)$postData;

$userData = (array)$data['user_data'];

$userId = $userData['id'];

$sql = "SELECT * FROM users WHERE user_facebook_api_id='$userId' LIMIT 1";

$watchedVideos = [];

if ($result = $mysqli->query($sql)) {

    if ($result->num_rows !== 0) {

        $row = $result->fetch_assoc();

        $row = (array)$row;

        if ($row['watched_videos']) {
            $watchedVideos = (array)json_decode($row['watched_videos']);
        }
    }

    $result->close();
}

$mysqli->close();

header('Content-type: application/json');
echo json_encode([
    'status' => 'success',
    'watched_videos' => $watchedVideos,
]);