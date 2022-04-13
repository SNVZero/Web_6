<?php


if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){
    require "../connect/connection.php";
//Проверка на то был ли совершен вход в админ аккаунт,кнопка переправляющая на вход, кнопка выхода с аккаунта админа и функционал комнаты админа

$user = 'u46878';
$pass = '2251704';
$db = new PDO('mysql:host=localhost;dbname=u46878', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

$res = $db->query("SELECT max(id) FROM users");
$row = $res->fetch();
$count = (int) $row[0];
?>

<!Doctype html>

<head>
    <link rel="stylesheet" href="adminroom.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="adminroom.css">
    <title>Комната администратора</title>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>


<body>
    <div class="wrapper">
        <header>
            <div class="top">
                <div class="content"></div>
                <div class="exit">
                    <a class ="quit" href="#">Выйти</a>
                </div>
            </div>
        </header>
    </div>
    <div class="wrapper">
        <div class="main_content">
            <select name="select_users" id="selector">
            <option selected disabled>Выбрать пользователя</option>
                <?php
                for($index =1 ;$index <= $count;$index++){
                    $check_user = mysqli_query($connect, "SELECT * FROM users WHERE id = $index");
                    $user = mysqli_fetch_assoc($check_user);
                    print("<option>" ."id : ". $user['id'] . "Имя : " . $user['name'] . "Почта : ". $user['mail'] . "Дата рождения : ". $user['date'] . "Пол : ". $user['gender'] . "Кол. конечностей : ". $user['limbs']  ."</option>");
                }
                ?>
            </select>

        </div>
    </div>


</body>


<?php
}
else
header('Location: index.php')

?>