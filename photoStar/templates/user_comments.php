<?php

    //pegar nome do usuario
    require_once("models/user.php");

    $user = new User();

    //ele tem que receber um obj de comments
    $fullName = $user->getNameLastname($comment->user);

?>

<div class="col-md-12 comments">
    <div class="row">
        <div class="col-md-1">
            <div class="profile-image-container comments-image" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $comment->user->imagem ?>')"></div>
        </div>
        <div class="col-md-9 author-details-container">
            <h4 class="author-name">
                <a href="<?= $BASE_URL ?>profile.php?id=<?= $comment->user->id ?>"><?= $fullName ?></a>
            </h4>
        </div>
        <div class="col-md-12">
            <p class="comment-title">Comentários: </p>
            <p><?= $comment->comments ?></p>
        </div>
    </div>
</div>