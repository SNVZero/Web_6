<?php
require "../connect/connection.php"
if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
{
    $login = $_SERVER['PHP_AUTH_USER'];
    $passsword = $_SERVER['PHP_AUTH_PW'];

    $check_amin = mysqli_query($connect, "SELECT * FROM admin WHERE login = '$login'");

    if(mysqli_num_rows($check_admin) > 0){
        $admin = mysqli_fetch_assoc($check_admin);
        if(password_verify($password,$admin['password'])){
            header('Location: adminroom.php');
        }
    }
    else  die("Неверная комбинация имя пользователя - пароль");
}
else
{
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.1 401 Unauthorized');
    die("Пожалуйст, введите имя пользователя и пароль");
}
