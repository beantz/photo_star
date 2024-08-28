<?php

    require_once("templates/header.php");
    require_once("dao/postDao.php");
    require_once("models/post.php");

    $userDao = new userDao($conn, $BASE_URL);
    $postDao = new PostDao($conn, $BASE_URL);
    $post = new Post();

    $userData = $userDao->verifyToken(true);

?>

<div class="main-container">
    <div class="col-md-8 offset-md-2">
        <div class="row justify-content-center create-post">
            <form action="<?= $BASE_URL ?>auth_post.php" method="POST" enctype="multipart/form-data" class="col-md-8">
            <input type="hidden" name="type" value="createpost">
                    <h2>crie seu post:</h2>
                    <div class="form-group">
                        <label for="title">Titulo:</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Digite o titulo">
                    </div>
                    <div class="form-group mt-3">
                        <label for="description">Descrição:</label>
                        <textarea class="form-control" name="description" id="description" rows="5" placeholder="fale sobre sua fotografia"></textarea>
                    </div>
                    <div class="form-group mt-3">
                        <label for="image">Selecione sua fotografia:</label>
                        <input type="file" class="form-control-file" name="image">
                    </div>
                <input type="submit" class="btn card mt-3" value="Postar">
            </form>
        </div>
    </div>    
</div>

<?php
    require_once("templates/footer.php");
?>