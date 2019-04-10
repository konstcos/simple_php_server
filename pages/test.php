<?php

require_once '../src/functions.php';
require_once '../settings.php';
require_once('../vendor/autoload.php');

use Firebase\JWT\JWT;


$tokenId    = base64_encode(random_bytes(32));
$issuedAt   = time();
$notBefore  = $issuedAt + 10;             //Adding 10 seconds
$expire     = 1036800;            // Adding 60 seconds
$serverName = 'success'; // Retrieve the server



/*
     * Create the token as an array
     */
$data = [
    'iat'  => $issuedAt,         // Issued at: time when the token was generated
    'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
    'iss'  => $serverName,       // Issuer
    'nbf'  => $notBefore,        // Not before
    'exp'  => $expire,           // Expire
    'data' => [                  // Data related to the signer user
        'userId'   => 'fffffffffffff', // userid from the users table
        'userName' => 'Konst', // User name
    ]
];

$secretKey = base64_decode($jwtKey);


$jwt = JWT::encode(
    $data,      //Data to be encoded in the JWT
    $secretKey, // The signing key
    'HS512'     // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
);

$unencodedArray = ['jwt' => $jwt];


echo(PHP_EOL);
echo('тест');
echo(PHP_EOL);
echo(PHP_EOL);

echo json_encode($unencodedArray);


echo(PHP_EOL);
echo('тест');
echo(PHP_EOL);
echo(PHP_EOL);
