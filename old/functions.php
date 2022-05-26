<?php
//Users Get
function getUsers($connect): void
{
	$usersLst = array();
	$users = mysqli_query($connect, "SELECT * FROM `users`");
	while ($user = mysqli_fetch_assoc($users)) {
		array_push($usersLst, $user);
	}
	echo json_encode($usersLst);
}

function getUser($connect, $id)
{
	$user = mysqli_query($connect, "SELECT * FROM `users` where id = '$id'");
	if (mysqli_num_rows($user) === 0) {
		http_response_code(404);
		$res = [
			"status" => false,
			"message" => "Post not found"
		];
		echo json_encode($res);
	}
	else
	{
		$user = mysqli_fetch_assoc($user);
		echo json_encode($user);
	}
}
//Users Post
function addUser($connect, $data)
{
	$password = $data['password'];
	$login = $data['login'];
	$name = $data['name'];
	$secondName = $data['secondName'];
	$gender = $data['gender'];
	$location = $data['location'];

	mysqli_query($connect,"INSERT INTO `users` (`password`, `login`, `name`, `secondName`, `gender`, `location`) VALUES ('$password', '$login', '$name', '$secondName', '$gender', '$location')");

	http_response_code(201);
	$res = [
		"status" => true,
		"post_id" => mysqli_insert_id($connect)
	];
	echo  json_encode($res);
}