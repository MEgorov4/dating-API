<?php
$connect = mysqli_connect('localhost', 'root','','datingdb');
if (!$connect)
{
	die('Fail connect to mysql');
}
return $connect;
