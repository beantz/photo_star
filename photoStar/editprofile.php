<?php
    require_once("templates/header.php");
    require_once("dao/userDao.php");
    require_once("models/user.php");

    $user = new User();
    
    $userDao = new userDao($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);

    $nameUser = $user->getNameLastname($userData);

?>

    <div class="main-container">
        <div class="edithprofile">
            <div class="col-md-12">
                <form action="<?= $BASE_URL ?>user_process.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name=type value="update">
                    <div class="row">
                        <div class="col-md-4">
                            <h1><?= $nameUser ?></h1>
                            <p class="page-description">Altere seus dados no formulario abaixo: </p>
                            <div class="form-group">
                                <label for="name">Nome: </label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Digite seu nome"
                                value="<?= $userData->name ?>">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Sobrenome: </label>
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Digite seu sobrenome"
                                value="<?= $userData->lastname ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail: </label>
                                <input type="text" readonly class="form-control disabled" id="email" name="email" placeholder="Digite seu email"
                                value="<?= $userData->email ?>">
                            </div>
                            <input type="submit" class="btn card mt-3" value="Alterar">
                        </div>
                        <!-- Foto -->
                        <div class="col-md-4" id="container-imagebio">
                            <div class="profile-image" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->imagem ?>')"></div>
                            <div class="form-group">
                                <label for="image">Foto: </label>
                                <input type="file" class="form-control-file" id="image" name="image">
                            </div>
                            <div class="form-group">
                                <label for="bio">Sobre você: </label>
                                <textarea class="form-control" name="bio" id="bio" rows="5" placeholder="Escreva sobre você"><?= $userData->bio ?></textarea>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row" id="change-password-container">
                    <div class="col-md-4">
                        <h2>Alterar senha:</h2>
                        <p class="page-description">Digite sua nova senha</p>
                        <form action="<?= $BASE_URL ?>user_process.php" method="POST">
                        <input type="hidden" name="type" value="changepassword">
                            <div class="form-group">
                                <label for="password">Senha:</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Digite sua nova senha">
                            </div>
                            <div class="form-group">
                                <label for="confirmpassword">Confirme sua senha:</label>
                                <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Confirme sua nova senha">
                            </div>
                            <input type="submit" class="btn card mt-3" value="Alterar senha">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
    require_once("templates/footer.php");
?>