<?php

$data = (array)$postData;

$userData = (array)$data['user_data'];

$videoId = $data['video'];
$userId = $userData['id'];
$email = $userData['email'];

$today = date("Y-m-d H:i:s");

$sql = "SELECT * FROM users WHERE user_facebook_api_id='$userId' LIMIT 1";

if ($result = $mysqli->query($sql)) {

    if ($result->num_rows !== 0) {

        $row = $result->fetch_assoc();

        $row = (array)$row;

        if ($row['watched_videos']) {
            $watchedVideos = (array)json_decode($row['watched_videos']);
        } else {
            $watchedVideos = [];
        }

        $watchedVideos[$videoId] = true;

        $watchedVideos = json_encode($watchedVideos);

        $sql = "UPDATE users SET watched_videos='$watchedVideos', updated_at='$today'  WHERE user_facebook_api_id='$userId'";
    }

    $mysqli->query($sql);

    $result->close();
}

$mysqli->close();

header('Content-type: application/json');
echo json_encode(['status' => 'success']);