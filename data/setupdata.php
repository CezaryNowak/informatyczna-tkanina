<?php

$config = require setDefaultPath("data/config.php");
$dsn = "mysql:host=".$config['host'].";dbname=".$config['database'].";charset=UTF8";
try
{
	$pdo = new PDO($dsn, $config['user'], $config['password']);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
	return $pdo;
} catch (PDOException $e)
{
	echo '<script> alert("Błąd połączenia ze serwerem")</script>';
	echo '<div class="error" style="text-align:center;">BRAK POŁĄCZENIA ZE SERWEREM PRZEPRASZAMY!</div>';
	http_response_code(404);
	die();
	//echo  $e->getMessage();
}
