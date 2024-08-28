<?php 

    require_once("templates/header.php");

    $postDao = new PostDao($conn, $BASE_URL);

    $posts = $postDao->getLatesPost();

?>

    <div class="main-container">
        <div class="title">
            <span id="main-title">galery.studio</span>
            <p class="home-description">Ola, este é um espaço destindo para compartilhar suas fotografias e contar suas historias, se divirta.</p>
        </div>
        <div class="col-md-12">
            <div class="allPosts">
                <div id="post-index">
                    <?php if(!empty($posts)):?>
                        <?php foreach($posts as $post): ?>
                            <?php require("templates/post_card.php"); ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="empty-list ">ainda não possui posts</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php 

    require_once("templates/footer.php");

?>