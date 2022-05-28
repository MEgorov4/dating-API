<?php


header("Access-Control-Allow-Origin: http://dating-API/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once 'config/database.php';
include_once 'objects/user.php';


$database = new Database();
$db = $database->getConnection();


$user = new User($db);

$data = json_decode(file_get_contents("php://input"));


$user->password = $data->password;
$user->login = $data->login;
$user->name = $data->name;
$user->secondname = $data->secondname;
$user->gender= $data->gender;
$user->location = $data->location;
if (
	isset($data) &&
	$user->create()
) {
	http_response_code(200);
	echo json_encode(array("message" => "Пользователь был создан."));
}

else {
	http_response_code(400);
	echo json_encode(array("message" => "Невозможно создать пользователя."));
}
?>