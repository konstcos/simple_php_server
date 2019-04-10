<?php


header('Content-type: application/json');
echo json_encode([
    'status' => 'success',
    'type' => 'send_registered_users',
]);