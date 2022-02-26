<?php
// 
ini_set('display_errors', 1);

// DB接続情報
$dsn = 'mysql:dbname=sho_test; host=localhost;';
$user = 'root';
$password = 'mysqlpa55';

$dbh = new PDO ($dsn, $user, $password);
?>