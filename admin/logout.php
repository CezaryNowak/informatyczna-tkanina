<?php

session_start();
if (isset($_SESSION['logged_id']) && isset($_SESSION['logged_login']))
{
	unset($_SESSION['logged_id']);
	unset($_SESSION['logged_login']);
	session_unset();
	session_destroy();
}
header('Location: ../index.php');
die();
