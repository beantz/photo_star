<?php 
    require_once("templates/header.php");
?>

<div class="main-container">
    <div class="col-md-12">
        <div class="row" id="auth-row">
            <div class="col-md-4" id="login-container">
                <h2>Entrar</h2>
                <form action="<?= $BASE_URL ?>auth_process.php" method="POST">
                    <input type="hidden" name="type" value="login">
                    <div class="form-group">
                        <label for="email-login">E-mail:</label>
                        <input type="email" class="form-control" name="email" id="email-login" placeholder="Digite seu e-mail">
                    </div>
                    <div class="form-group">
                        <label for="password-email">Senha:</label>
                        <input type="password" class="form-control" name="password" id="password-email" placeholder="Digite sua senha">
                    </div>
                    <input type="submit" class="btn card mt-3" value="entrar">
                </form>
            </div>
            <!-- Registrar-->
            <div class="col-md-4" id="register-container">
                <h2>Registrar</h2>
                <form action="<?= $BASE_URL ?>auth_process.php" method="POST">
                    <input type="hidden" name="type" value="register">
                    <div class="form-group">
                        <label for="email-register">E-mail:</label>
                        <input type="email" class="form-control" name="email" id="email-register" placeholder="Digite seu e-mail">
                    </div>
                    <div class="form-group">
                        <label for="name">Nome:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Digite seu nome">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Sobrenome:</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Digite seu sobrenome">
                    </div>
                    <div class="form-group">
                        <label for="password-register">Senha:</label>
                        <input type="password" class="form-control" name="password" id="password-register" placeholder="Digite sua senha">
                    </div>
                    <div class="form-group">
                        <label for="confirmpassword">Confirme a sua senha:</label>
                        <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Confirme a sua senha">
                    </div>
                    <input type="submit" class="btn card mt-3" value="registrar">
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
    require_once("templates/footer.php");
?>