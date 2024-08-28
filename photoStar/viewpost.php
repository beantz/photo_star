<?php

    require_once("templates/header.php");
    require_once("dao/postDao.php");
    require_once("dao/userDao.php");
    require_once("dao/commentsDao.php");
    require_once("models/post.php");
    require_once("models/user.php");

    $postDao = new PostDao($conn, $BASE_URL);
    $user = new User();
    $userDao = new userDao($conn, $BASE_URL);
    $commentsDao = new commentsDao($conn, $BASE_URL);

    $id = filter_input(INPUT_GET, "id");

    $userData = $userDao->verifyToken();

    $post = $postDao->getPostfindById($id);

    if($post) {

        $commentsPost = $commentsDao->getCommentsByPost($post->id);
        
    }

?>

<div class="main-container">
    <div class="col-md-8 offset-md-2">
        <div class="row post-container" id="post-container">
        <!--aqui vai ficar post, bio, title -->
            <h1 id="post-title"><?= $post->title ?></h1>
            <div id="post-image" style="background-image: url('<?= $BASE_URL ?>img/post/<?= $post->imagem ?>')"></div>
            <?php if(!empty($post->description)): ?>
                <p id="profile-description" ><?= $post->description ?></p>
            <?php else: ?>
                <p class="empty-list">O usuário ainda não escreveu nada aqui...</p>
            <?php endif; ?>
        </div>
        <?php if($userData): ?>
            <div id="comments-container">
                <h4>Envie seu comentário:</h4>
                <p class="page-description">Preencha o formulario com o seu comentário sobre o post</p>
                <form action="<?= $BASE_URL ?>comments_process.php" id="comments-form" method="POST">
                    <input type="hidden" name="type" value="create">
                    <input type="hidden" name="post_id" value="<?= $post->id ?>">
                    <input type="hidden" name="user_id" value="<?= $userData->id ?>">
                    <div class="form-group">
                        <label for="comments">Seu comentário:</label>
                        <textarea name="comments" id="comments" rows="3" class="form-control" placeholder="O que você achou do post?"></textarea>
                    </div>
                    <input type="submit" class="btn card mt-3" value="Enviar comentário">
                </form>
            </div>
            <?php else: ?>
                <p class="empty-list">Você precisa estar logado para poder comentar!</p>
            <?php endif; ?>
            <!-- comentarios -->
            <?php foreach($commentsPost as $comment): ?>
                <?php require("templates/user_comments.php"); ?>
            <?php endforeach; ?>
            <?php if(count($commentsPost) == 0): ?>
                <p class="empty-list">Ainda não há comentários por aqui!</p>
        <?php endif; ?>
    </div>
</div>

<?php 
    require_once("templates/footer.php");
?>