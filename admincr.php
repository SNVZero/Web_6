<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' ){
$login = 'admin';
$password = 'igod';
$hash = password_hash($password,PASSWORD_DEFAULT);

$user = 'u46878';
$pass = '2251704';
$db = new PDO('mysql:host=localhost;dbname=u46878', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
try{

    $stmt = $db->prepare("INSERT INTO admin SET login = ?, password = ?");
    $stmt -> execute(array($login,$hash));
}catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
}
}
?>