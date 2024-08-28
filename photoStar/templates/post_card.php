
<div class="card post-card" id="post-card">
    <div class="card-post-img" style="background-image: url('<?= $BASE_URL ?>img/post/<?= $post->imagem ?>')"></div>
        <div class="card-body">
            <h5 class="card-title">
                <a href="<?= $BASE_URL ?>viewpost.php?id=<?= $post->id ?>"><?= $post->title ?></a>
            </h5>
            <div class="card-describe"><?= $post->description ?></div>
        </div>
</div>