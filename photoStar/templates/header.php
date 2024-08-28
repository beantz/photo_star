<?php 

    require_once("globals.php");
    require_once("db.php");
    require_once("models/message.php");
    Require_once("dao/userDao.php");
    require_once("models/user.php");
    Require_once("dao/postDao.php");

    $message = new message($BASE_URL);
    $userDao = new userDao($conn, $BASE_URL);

    $user = new User();

    $mensagem = $message->insertMessage();

    if(!empty($mensagem["msg"])) {
        $message->clearMessage();
    }

    $userData = $userDao->verifyToken();

    $nameUser = $user->getNameLastname($userData);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>galery.studio</title>
    <link rel="short icon" href="<?= $BASE_URL ?>img/camera.png">
    <link rel="stylesheet" href="<?= $BASE_URL ?>css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.css" integrity="sha512-VcyUgkobcyhqQl74HS1TcTMnLEfdfX6BbjhH8ZBjFU9YTwHwtoRtWSGzhpDVEJqtMlvLM2z3JIixUOu63PNCYQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<!-- aqui vai o header -->
    <header>
        <nav id="main-navbar" class="pipe">
            <div class="icon">
                <a href="<?= $BASE_URL ?>"><i class="fa-sharp-duotone fa-solid fa-bars"></i></a>
            </div>
            <div class="nav-itens">
                <?php if(!empty($userData)): ?>
                    <ul>
                        <li>
                            <a href="<?= $BASE_URL ?>profile.php"><?= $nameUser ?></a>
                        </li>
                        <li>
                            <a href="<?= $BASE_URL ?>create_post.php"> Post </a>
                        </li>
                        <li>
                            <a href="<?= $BASE_URL ?>logout.php"> Sair </a>
                        </li>
                    </ul>
                <?php else: ?>
                    <ul>
                        <li>
                            <a href="<?= $BASE_URL ?>auth.php"> Entrar / Cadastrar </a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <?php if(!empty($mensagem["msg"])): ?>
        <div class="msg-header">
            <p class="msg <?= $mensagem["type"] ?>"><?= $mensagem["msg"] ?></p>
        </div>
    <?php endif; ?> 