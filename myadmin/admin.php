<?php
require "../connect/connection.php";
if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))//Проверка были ли введенны пароль и логин при HTTP авториции,
//хранящиеся в глобальном массиве $_SERVER
{//Если логин и пароль были введены сохраняем их в переменных
    $login = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];

    $check_admin = mysqli_query($connect, "SELECT * FROM admin WHERE login = '$login'");//Проверка логина на соответствие
    //с логином хранящимся в таблице БД

    if(mysqli_num_rows($check_admin) > 0){//Если логины совпали идет проверка пароля на совпадение
        $admin = mysqli_fetch_assoc($check_admin);
        if(password_verify($password,$admin['password'])){//Если пароли совпали идет перенаправление на страницу администратора
            header('Location: adminroom.php');
        }//Если логин или пароль не совпали то пользователю возращается заголовок 401 Unauthorized и повторный логин может быть
        //соверщен только после полной перезагрузки браузера
         else  die("Неверная комбинация имя пользователя - пароль");
    }
    else  die("Неверная комбинация имя пользователя - пароль");
}
else
{
    header('WWW-Authenticate: Basic realm="My Realm"');//Если при перевой переадресации не были ведены пароль и логин сервер предлагает
    //пройти HTTP авторизацию
    header('HTTP/1.1 401 Unauthorized');
    die("Пожалуйст, введите имя пользователя и пароль");
}
?>