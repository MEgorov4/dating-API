<?php

function getUsers($connect): void
{
	$users = mysqli_query($connect, "SELECT * FROM `users`");
	while ($user = mysqli_fetch_assoc($users)) {
		$usersLst = $user;
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