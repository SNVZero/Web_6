<?php

if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){
    require "../connect/connection.php";
// функционал комнаты админа, разобраться с автоинкерментом для этого изменить структуру таблицы  чтоб она брала максимальный столбец и записывала его в id

$user = 'u46878';
$pass = '2251704';
$db = new PDO('mysql:host=localhost;dbname=u46878', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

$res = $db->query("SELECT max(id) FROM users");
$row = $res->fetch();
$count = (int) $row[0];

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['delete_user'])){
        $count --;
        $inc =$count;
        $user_id =  mysqli_real_escape_string($connect ,$_POST['select_user']);

        $sql = "DELETE FROM users WHERE id = '$user_id'";
        mysqli_query($connect, $sql);

        $sql = "DELETE FROM super_power WHERE id = '$user_id'";
        mysqli_query($connect, $sql);

        for($index=$count;$index>0;$index--){
            try{
            $stmt = $db->prepare("UPDATE users SET id = ? WHERE id = ?");
            $stmt -> execute(array($index,$index+1));
            }catch(PDOException $e){
                print('Error : ' . $e->getMessage());
                exit();
            }
        }
        for($index=$count;$index>0;$index--){
            try{
            $stmt = $db->prepare("UPDATE super_power SET id = ?, human_id =? WHERE id = ?");
            $stmt -> execute(array($index,$index,$index+1));
            }catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
            }
        }

        $sql = "ALTER TABLE users AUTO_INCREMENT = '$inc'";
        mysqli_query($connect, $sql);

        $sql = "ALTER TABLE super_power AUTO_INCREMENT = '$inc'";
        mysqli_query($connect, $sql);




    }
}
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
                    <a class ="quit" href="../index.php">Выйти</a>
                </div>
            </div>
        </header>
    </div>
    <div class="wrapper">
        <div class="main_content">
            <form method="POST" action="adminroom.php">
                <select name="select_user" id="selector">
                <option selected disabled>Выбрать пользователя</option>
                    <?php
                    for($index =1 ;$index <= $count;$index++){
                        $check_user = mysqli_query($connect, "SELECT * FROM users WHERE id = $index");
                        $user = mysqli_fetch_assoc($check_user);
                        if($user['id'] === $index){
                            print("<option value =" . $index . ">" . "id : ". $user['id'] . " Имя : " . $user['name'] . " Почта : ". $user['mail'] . " Дата рождения : ". $user['date'] . " Пол : ". $user['gender'] . " Кол. конечностей : ". $user['limbs']  ."</option>");
                        }
                    }
                    ?>
                </select>
                <button name ="delete_user" type = "submit">Удалить пользователя</button>
            </form>


        </div>
    </div>


</body>


<?php
}
else
header('Location: ../index.php')

?>