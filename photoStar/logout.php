<?php

    require_once("dao/userDao.php");
    require_once("globals.php");
    require_once("db.php");
    require_once("models/message.php");

    $userDao = new userDao($conn, $BASE_URL);

    $message = new message($BASE_URL);

    //verificar se tem usuario logado

    if($userDao) {
        $userDao->destroyToken();
    }
    
