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

        $user_id =  mysqli_real_escape_string($connect ,$_POST['select_user']);

        $sql = "DELETE FROM users WHERE id = '$user_id'";
        mysqli_query($connect, $sql);

        $sql = "DELETE FROM super_power WHERE id = '$user_id'";
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
<?php
    if(is_null(@$_POST['edit_user'])){
?>
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
                            if($user['id'] == $index){
                                print("<option value =" . $index . ">" . "id : ". $user['id'] . " Имя : " . $user['name'] . " Почта : ". $user['mail'] . " Дата рождения : ". $user['date'] . " Пол : ". $user['gender'] . " Кол. конечностей : ". $user['limbs']  ."</option>");
                            }
                        }
                        ?>
                    </select>
                    <div class="btn_action">
                        <button name ="edit_user" type = "submit">Редактировать пользователя</button>
                        <button name ="delete_user" type = "submit">Удалить пользователя</button>
                    </div>
                </form>


            </div>
        </div>
    <?php } ?>

    <?php
        if(isset($_POST['edit_user']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
            $user_id =  mysqli_real_escape_string($connect ,$_POST['select_user']);
            $check_user = mysqli_query($connect, "SELECT * FROM users WHERE id = '$user_id'");
            $user = mysqli_fetch_assoc($check_user);

            $check_power = mysqli_query($connect, "SELECT * FROM super_power WHERE human_id = '$user_id'");
            $power =mysqli_fetch_assoc($check_power);

            setcookie('name_value',$user['name']);
            setcookie('email_value',$user['mail']);
            setcookie('bio_value',$user['bio']);
            setcookie('year_value',$user['date']);
            setcookie('gender_value',$user['gender']);
            setcookie('limbs_value',$user['limbs']);
            setcookie('ability_value',$power['superabilities']);
            setcookie('agree_value', '1');

            $value['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
            $value['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
            $value['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
            $value['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
            $value['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
            $value['limbs'] = empty($_COOKIE['limbs_value']) ? '' : $_COOKIE['limbs_value'];

            if(empty($_COOKIE['ability_value'])){
                $value_ability[] = array();

                $value_ability[0] = ' ';
                $value_ability[1] = ' ';
                $value_ability[2] = ' ';
                $value_ability[3] = ' ';


                }else{
                    $value_ability = explode(',',$_COOKIE['ability_value']);
                    $a = count($value_ability)-1;
                    for($a ; $a < 4 ; $a++){
                        $value_ability[$a] = '';
                    }
                }
            }
            ?>
            <?php
            if(isset($_POST['edit_user'])){?>

            <form method = "POST" action = "adminroom.php">
                <div>
                    <input class="webform__form-elem form__input _req"  id="names" type="text" name="name"
                        placeholder="Имя" value= "<?php print($value['name']); ?>" >
                </div>

                <div>
                <input class="webform__form-elem form__input _req _email" id="email" type="email" name="email"
                        placeholder="E-mail" value= "<?php print($value['email']);?>">

                </div>

                <div>
                    <textarea id="comment" class="webform__form-elem form__input _req" type="text" name="bio" placeholder="Биография" ><?php print($value['bio']); ?></textarea>
                </div>

                <div class="form_item form-group">
                    <label for="formDate" style="color: white;">Дата рождения:</label>
                    <input type="date" class="form_input form__input _req form-control w-50  bg-white rounded" name="year" id="dates" value="<?php print($value['year']); ?>">
                </div>

                <div class="gender">
                    <label style="margin-right: 5px;">Пол : </label>
                    <div>
                        <input type="radio" id="male" name="gender" value="m"
                            <?php
                                if($value['gender'] == 'm'){
                                    print('checked');
                                }
                            ?>
                        />
                        <label for="male" id="male">мужской</label>
                    </div>
                    <div>
                        <input type="radio" id="female"name="gender" value="f"
                            <?php
                                if($value['gender'] == 'f'){
                                    print('checked');
                                }
                            ?>
                        />
                        <label for="female" id="female">женский</label>
                    </div>
                </div>

                <div class="limbs">
                    <label>Количество конечностей :</label>
                    <input type="radio" id="2" name="limbs" value="2"
                        <?php
                            if($value['limbs'] == '2'){
                                print('checked');
                            }
                            ?>
                    >
                    <label for="2" id="2">2</label>
                    <input type="radio" id="4" name="limbs" value="4"
                            <?php
                                if($value['limbs'] == '4'){
                                    print('checked');
                                }
                            ?>
                    >
                    <label for="4" id="4">4</label>
                    <input type="radio" id="8" name="limbs" value="8"
                        <?php
                            if($value['limbs'] == '8'){
                                print('checked');
                            }
                        ?>
                    >
                    <label for="8" id="8">8</label>
                    <input type="radio" id="16" name="limbs" value="16"
                        <?php
                            if($value['limbs'] == '16'){
                                print('checked');
                            }
                        ?>
                    >
                    <label for="16" id="16">16</label>
                </div>

                <div class="capabilities">
                    <select name="capabilities[]" size="2" multiple>
                        <option value="s1"
                            <?php
                                if($value_ability[0] == 'immortal'){
                                    print('selected');
                                }
                            ?>
                        >бессмертие</option>
                        <option value="s2"
                            <?php
                                if($value_ability[0] == 'noclip' || $value_ability[1] == 'noclip'){
                                    print('selected');
                                }
                            ?>
                        >прохождение сквозь стены</option>
                        <option value="s3"
                            <?php
                                if($value_ability[0] == 'flying' || $value_ability[1] == 'flying' || $value_ability[2] == 'flying'){
                                    print('selected');
                                }
                            ?>
                        >левитация</option>
                        <option value="s4"
                            <?php
                                if($value_ability[0] == 'lazer' || $value_ability[1] == 'lazer' || $value_ability[2] == 'lazer' || $value_ability[3] == 'lazer' ){
                                    print('selected');
                                }
                            ?>
                        >лазеры из глаз</option>
                    </select>
                </div>

                <div class="form__checkbox">
                    <input class="checkbox__input _req" type="checkbox" id="userAgreement"  name="agree"
                        <?php
                            if($_COOKIE['agree_value']){
                                print('checked');
                            }
                        ?>
                    >
                        <label class="checkbox__label" for="userAgreement">Отправляя заявку, я даю согласие на<a>обработку своих персональных данных</a>.<span>*</span></label>
                </div>


                <div>
                    <input class="webform__form-btn" type="submit" name="edit" value="Отправить">
                </div>
            </form>

    <?php
    }
    ?>


</body>


<?php
}
else
header('Location: ../index.php');

?>