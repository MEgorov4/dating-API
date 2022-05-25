<?php
$connect = require_once "CONNECTION/connect.php";
require_once "FUNCTIONS/functions.php";
header("Content-type: json/application");

$method = $_SERVER['REQUEST_METHOD'];

$usersLst = [];
$urlData = $_GET['url'];
$params = explode('/', $urlData);

$type = $params[0];
if (isset($params[1])) {
	$id = $params[1];
}

switch ($method) {
	case 'GET':
	{
		if ($type == 'users') {
			{
				if (isset($id)) {
					getUser($connect, $id);
				} else {
					getUsers($connect);
				}
			}
		}
	}
	case 'POST':
	{

	}
}

