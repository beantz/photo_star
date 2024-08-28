<?php

    require_once("templates/header.php");
    require_once("dao/postDao.php");
    require_once("models/post.php");

    $userDao = new userDao($conn, $BASE_URL);
    $postDao = new PostDao($conn, $BASE_URL);
    $user = new User();
    $post = new Post();

    $userData = $userDao->verifyToken(true);
    $fullName = $user->getNameLastname($userData);

    $allPosts = $postDao->getPostByUserId($userData->id);
?>

<div class="main-container">
    <div class="col-md-8 offset-md-2">
        <div class="row profile-container">
        <!--aqui vai ficar a foto, bio e post -->
            <div class="col-md-12">
                <h1 id="page-title"><?= $fullName ?></h1>
                <div class="profile-image" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->imagem ?>')"></div>
                <h3 class="about-title mt-3">Sobre:</h3>
                <?php if(!empty($userData->bio)): ?>
                    <p class="profile-description"><?= $userData->bio ?></p>
                <?php else: ?>
                    <p class="profile-description">O usuário ainda não escreveu nada aqui...</p>
                <?php endif; ?>
            </div>
            <div class="col-md-12">
                <h3>postagens feitas:</h3>
                <div class="post-container">
                    <!-- aqui ficam os posts-->
                    <?php if($allPosts): ?>
                        <?php foreach($allPosts as $post): ?>
                            <?php require("templates/post_card.php"); ?>
                            <!-- colocar botões aqui-->
                            <div id="card-container">
                                <div class="card-bottom" id="edit">
                                    <a href="<?= $BASE_URL ?>editpost.php?id=<?= $post->id ?>"><i class="fa-regular fa-pen-to-square"></i></a>
                                </div>
                                <form action="<?= $BASE_URL ?>auth_post.php" method="POST">
                                <input type="hidden" name="type" value="delete">
                                <input type="hidden" name="id" value="<?= $post->id ?>">
                                    <button type="submit" class="card-bottom" id="delete">
                                        <i class="fa-solid fa-delete-left"></i></a>
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="empty-list">você não possui nenhum post ainda</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
       
    </div>
</div>
<?php
    require_once("templates/footer.php");
?>