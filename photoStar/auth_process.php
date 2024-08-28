<?php 
    require_once("globals.php");
    require_once("db.php");
    require_once("dao/userDao.php");
    require_once("models/user.php");
    require_once("models/message.php");

    $userDao = new userDao($conn, $BASE_URL);

    $message = new message($BASE_URL);

    $type = filter_input(INPUT_POST, "type");

    if ($type === "register") {

        $email = filter_input(INPUT_POST, "email");
        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

        if($email && $name && $password && $confirmpassword) {
            
            if($password === $confirmpassword) {

                if($userDao->findByEmail($email) === false) {

                    $user = new User();

                    $userToken = $user->generateToken();
                    $finalPassword = $user->generatePassword($password);

                    $user->name = $name;
                    $user->lastname = $lastname;
                    $user->email = $email;
                    $user->password = $finalPassword;
                    $user->token = $userToken;

                    $authUser = true;

                    //inserir obj no banco
                    $userDao->create($user, $authUser);

                } else {

                    $message->createMessage("Esse e-mail já está cadastrado" , "error" , "back");

                }

            } else {

                $message->createMessage("Senhas não batem, tente novamente", "error", "back");

            }

        } else {

            $message->createMessage("Você deve inserir ao menos o nome, email, senha e confirmação da senha", "error", "back");

        }
        
    } else if($type === "login") {

        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");

        if($userDao->authenticateUser($email, $password)) {

            $message->createMessage("seja bem vindo de volta", "success", "editprofile.php");

        } else {
            $message->createMessage("Usuario e/ou senha incorretos.", "error", "back");

        }

    } else {
        $message->createMessage("Informações invalidas.", "error", "back");
    }

