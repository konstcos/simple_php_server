<?php

/**
 * Проверка регистрации пользователя
 *
 */
function checkFaceBookToken($userToken, $faceBookUserId, $faceBookAppId)
{

    $input_token = $userToken;
    $access_token = $userToken;

    $url_token = 'https://graph.facebook.com/debug_token?input_token=' . $input_token . '&access_token=' . $access_token;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url_token);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $data = (array)json_decode(curl_exec($ch), true);    //print_r($data);

    $result = false;

    if (isset($data['data']) &&
        $data['data']['app_id'] == $faceBookAppId &&
        $data['data']['user_id'] == $faceBookUserId &&
        $data['data']['is_valid']) {

        $result = true;
    }

    return $result;
}


/**
 * Сохранение пользователя в списке рассылки
 */
function addUserToSendMsg($email, $name)
{


    /**
     * Получение токена
     *
     */
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://gconvertrest.sendmsg.co.il/api/sendMsg/token");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
  \"siteID\": 165,
  \"password\": \"sUc159468\"
}");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    $tokenArray = (array)json_decode($response);
    $token = $tokenArray['Token'];

    /**
     * Сохранение пользователя
     *
     */
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://gconvertrest.sendmsg.co.il/api/sendMsg/AddUsersOnly");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    $values = [
      [
          'EmailAddress' => $email,
          'Cellphone' => '',
          'userSystemFields' => [
              [
                  'Key' => 'name',
                  'Value' => $name
              ]
          ]
      ]
    ];

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($values));


    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Authorization: " . $token,
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    var_dump($response);
}
