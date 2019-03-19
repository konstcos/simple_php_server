<?php

$data = $postData;

$userData = (array)$data['user_data'];

$userId = $userData['id'];
$email = $userData['email'];

$today = date("Y-m-d H:i:s");

$sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";

//$mysqli->query($sql);

if ($result = $mysqli->query($sql)) {

    if ($result->num_rows === 0) {
        $sql = "INSERT INTO users (user_facebook_api_id, email, updated_at) VALUES ('$userId', '$email', '$today')";
    } else {
//        $sql = "UPDATE users (user_facebook_api_id, email, updated_at) VALUES ('$userId', '$email', '$today')";
        $sql = "UPDATE users SET user_facebook_api_id='$userId', updated_at='$today'  WHERE email='$email'";
    }

    $mysqli->query($sql);

    $result->close();
}


$mysqli->close();

header('Content-type: application/json');
echo json_encode(['status' => 'success']);
