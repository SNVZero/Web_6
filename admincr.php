<?php

$login = 'admin';
$password = 'igod';
$hash = password_hash($password,PASSWORD_DEFAULT);

$user = 'u46878';
$pass = '2251704';
$db = new PDO('mysql:host=localhost;dbname=u46878', $user, $pass, array(PDO::ATTR_PERSISTENT => true));


$stmt = $db->prepare("INSERT INTO admin SET login = ?, password = ?");
$stmt -> execute(array($login,$hash);