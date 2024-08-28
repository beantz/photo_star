<?php 
    require_once("templates/header.php");
    require_once("dao/postDao.php");
    require_once("dao/userDao.php");

    $postDao = new PostDao($conn, $BASE_URL);
    $userDao = new userDao($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);

    $id = filter_input(INPUT_GET, "id");

    $post = new Post();

    if(!empty($id)) {
        
        $postEdit = $postDao->getPostfindById($id);
    }

?>

<div class="main-container">
        <div class="col-md-8 offset-md-2">
            <div class="row justify-content-center editpost">
                <form action="<?= $BASE_URL ?>auth_post.php" method="POST" enctype="multipart/form-data" class="col-md-8">
                <input type="hidden" name="type" value="editpost">
                <input type="hidden" name="id" value="<?= $postEdit->id ?>">
                        <h2>edite seu post:</h2>
                        <div class="form-group">
                            <label for="title">Titulo:</label>
                            <input type="text" class="form-control" name="title" value="<?= $postEdit->title ?>" placeholder="Digite o titulo">
                        </div>
                        <div class="form-group mt-3">
                            <label for="description">Descrição:</label>
                            <textarea class="form-control" name="description" rows="5" placeholder="fale sobre sua fotografia"><?= $postEdit->description ?></textarea>
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