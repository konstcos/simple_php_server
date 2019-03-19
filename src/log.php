<?php

$saveData = [
    'log' => $postData,
];

$data = json_encode($saveData);

$sql = "INSERT INTO log (data) VALUES ('$data')";

$mysqli->query($sql);

header('Content-type: application/json');
echo json_encode([
    'status' => 'success'
]);