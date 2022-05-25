<?php
require_once 'CONECTION/connect.php';
if (isset($_POST)) {
	$login = $_POST['login'];
	$password = $_POST['login'];

	$query = mysqli_fetch_all(mysqli_query(($connect,'SELECT users.password, users.password FROM users'));
	foreach ($query as $item) {
		if ($item[0] == $password && $item[1] == $login) {
			return true;
		}
	}
	return false;

}
return false;