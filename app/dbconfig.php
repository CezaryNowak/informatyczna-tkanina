<?php
$config = require "./data/config.php";
$dsn = "mysql:host=".$config['host'].";dbname=".$config['database'].";charset=UTF8";
$result = 0;
try{
$PDO = new PDO($dsn, $config['user'], $config['password']);
$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);

$result = $PDO->prepare("SHOW TABLES");
$result->execute();
$result = $result->fetchAll();
if(count($result)<=0){
fillDataBase($PDO); }
return $PDO;
} catch (PDOException $e)
{   var_dump($result);
echo '<div class="error" style="text-align:center;">BRAK POŁĄCZENIA ZE SERWEREM PRZEPRASZAMY!</div>';
http_response_code(404);
echo  $e->getMessage();
die();

}