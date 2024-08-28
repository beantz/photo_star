<?php

    require_once("db.php");
    require_once("globals.php");
    require_once("models/user.php");
    require_once("models/message.php");
    require_once("dao/userDao.php");

    $message = new message($BASE_URL);

    $userDao = new userDao($conn, $BASE_URL);

    $type = filter_input(INPUT_POST, "type");

    if($type == "update") {

        $userData = $userDao->verifyToken();

        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $bio = filter_input(INPUT_POST, "bio");

        $userData->name = $name;
        $userData->lastname = $lastname;
        $userData->email = $email;
        $userData->bio = $bio;

        $user = new User();

        //Upload da imagem
        if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

            $image = $_FILES["image"];

            //checar o tipo da imagem
            if(in_array($image["type"], ["image/jpeg" , "image/jpg" , "image/png"])) {

                //checar se é jpg
                if(in_array($image["type"], ["image/jpeg", "image/jpg"])) {

                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);

                } else {

                    $imageFile = imagecreatefrompng($image["tmp_name"]);

                }

                $imageName = $user->imageGenerateName();

                imagejpeg($imageFile, "./img/users/".$imageName, 100);

                $userData->imagem = $imageName;

            } else {

                $message->createMessage("Tipo inválido de imagem, insira uma imagem png ou jpg!", "error", "back");

            }

        }

        $userDao->update($userData);

    } else if($type == "changepassword") {

        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

        $userData = $userDao->verifyToken();

        $id = $userData->id;

        if($password == $confirmpassword) {

            $user = new User();

            $finalPassword = $user->generatePassword($password);

            $user->password = $finalPassword;
            $user->id = $id;

            $userDao->changePassword($user);

        } else {
            $message->createMessage("as senhas não são iguais.", "error", "back");
        }

    } else {
        $message->createMessage("Informações invalidas.", "error", "back");
    }

