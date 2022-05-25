<?php
require_once 'CONECTION/connect.php';
if (isset($_POST))
{
	$name = $_POST['name'];
	$secondName = $_POST['secondName'];
	$password = $_POST['password'];
	$password_repeat = $_POST['password_repeat'];
	$login = $_POST['login'];
	$gender = $_POST['gender'];
	if ($password == $password_repeat)
	{
		$query = mysqli_fetch_all(mysqli_query($connect,"SELECT users.login FROM users"));
		if (loginIsExists($query,$login))
		{
				return false;
		}
		else
		{
			mysqli_query($connect, "INSERT INTO `users` (`password`, `login`, `name`, `secondName`, `gender`) VALUES ( '$password', '$login', '$name', '$secondName', '$gender')");

		}

	}
	return false;
}
return false;
function loginIsExists($query, $login)
{
	foreach ($query as $item) {
		if ($item == $login)
		{
			return true;
		}
	}
	return false;
}