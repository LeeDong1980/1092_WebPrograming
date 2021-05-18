<?php
$db_server = "localhost";
$db_user = "id16582870_username";
$db_passwd = "BjF9Cq9Dh1q%I?K_";
$db_name = "id16582870_leedong_db";
 
try {
    $dsn = "mysql:host=$db_server;dbname=$db_name";
    $dbh = new PDO($dsn, $db_user, $db_passwd);
}
catch (Exception $e){
    die('無法對資料庫連線!');
}

$dbh->exec("SET NAMES utf-8");
?>