<?php

$data = $postData;

header('Content-type: application/json');
//echo json_encode([
//    'status' => 'success',
//    'message_data' => $data,
//]);
//exit();


$content = array(
    "en" => $data['message'],
    "he" => $data['message'],
);

$heading = array(
    "en" => $data['title'],
    "he" => $data['title'],
);

$fields = [
    'app_id' => "6aba3a22-3167-41bf-a028-9ee2b9af9e2c",
    'included_segments' => array('All'),
//    'data' => [
//        "foo" => "bar",
//        "foo1" => "bar",
//        "foo2" => "bar",
//    ],
//    'url' => 'http://lmcrm.cos',
    'contents' => $content,
    'headings' => $heading,
];

if (isset($data['link']) && strlen(trim($data['link'])) > 0) {
    $fields['url'] = $data['link'];
}

$fields = json_encode($fields);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
    'Authorization: Basic MmY3MTdlY2UtOTVkMS00N2IzLWE2NmUtNGZmNGExMWZhM2Vi'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
$response = curl_exec($ch);
curl_close($ch);


echo json_encode([
    'status' => 'success',
    'message_data' => $data,
]);
exit();

//return $response;

//var_dump($response);
//echo(PHP_EOL);
//echo('ok' .PHP_EOL);