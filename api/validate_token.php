<?php
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/core.php';
include_once 'libs/php-jwt-main/src/BeforeValidException.php';
include_once 'libs/php-jwt-main/src/ExpiredException.php';
include_once 'libs/php-jwt-main/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-main/src/JWT.php';
include_once 'libs/php-jwt-main/src/Key.php';

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

$data = json_decode(file_get_contents("php://input"));

$jwt = $data->jwt ?? "";

if (isset($jwt)) {

	try {
		$decoded = JWT::decode($jwt, new Key($key, 'HS256'));
		http_response_code(200);

		echo json_encode([
			"message" => "Доступ разрешен.",
			"data" => $decoded->data,
		]);
	}
	catch (Exception $e) {

		http_response_code(401);
		echo json_encode([
			"message" => "Доступ закрыт.",
			"error" => $e->getMessage(),
		]);
	}
}
else {

	http_response_code(401);

	echo json_encode(["message" => "Доступ запрещён."]);
}