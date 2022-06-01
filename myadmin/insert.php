<?php

    require_once "../connect/db.php";
    $login = "admin";
    $password = "admin";
    $hash = password_hash($password,PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO admin SET login = ?, password = ?");
    $stmt -> execute([$login,$hash]);