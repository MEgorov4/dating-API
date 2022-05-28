<?php
header("Access-Control-Allow-Origin: *");
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

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

include_once 'config/database.php';
include_once 'objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

$jwt = $data->jwt ?? "";

if (isset($jwt)) {

	try {
		$decoded = JWT::decode($jwt, new Key($key, 'HS256'));

		$user->name = $data->name;
		$user->secondname = $data->secondname;
		$user->login = $data->login;
		$user->password = $data->password;
		$user->gender = $data->gender;
		$user->location = $data->location;
		$user->id = $decoded->data->id;

		if ($user->update()) {
			$token = [
				"iss" => $iss,
				"aud" => $aud,
				"iat" => $iat,
				"nbf" => $nbf,
				"data" => [
					"id" => $user->id,
					"name" => $user->name,
					"secondName" => $user->secondname,
					"email" => $user->login,
					"gender" => $user->gender,
					"location" => $user->location,
				],
			];
			$jwt = JWT::encode($token, $key, 'HS256');
			http_response_code(200);
			echo json_encode(
				[
					"message" => "Пользователь был обновлён",
					"jwt" => $jwt,
				]
			);
		}
		else {
			http_response_code(401);

			echo json_encode(["message" => "Невозможно обновить пользователя."]);
		}
	}
	catch (Exception $e) {
		http_response_code(401);
		echo json_encode([
			"message" => "Доступ закрыт",
			"error" => $e->getMessage(),
		]);
	}
}
else {
	http_response_code(401);
	echo json_encode(["message" => "Доступ закрыт."]);
}
?>
