<?php 
    
    require_once("globals.php");
    require_once("db.php");
    require_once("models/message.php");
    require_once("models/comments.php");
    require_once("models/post.php");
    require_once("dao/commentsDao.php");
    require_once("dao/userDao.php");
    require_once("dao/postDao.php");

    $message = new Message($BASE_URL);
    $userDao = new UserDao($conn, $BASE_URL);
    $postDao = new postDao($conn, $BASE_URL);
    $commentsDao = new commentsDao($conn, $BASE_URL);

    $type = filter_input(INPUT_POST, "type");

    if($type === "create") {

        $post_id = filter_input(INPUT_POST, "post_id");
        $commentsText = filter_input(INPUT_POST, "comments");
        $user_id = filter_input(INPUT_POST, "user_id");

        $comments = new Comments();

        //verificar se tem um post com esse id
        $postData = $postDao->getPostfindById($post_id);

            if(!empty($postData)) {

                $comments->comments = $commentsText;
                $comments->post_id = $post_id;
                $comments->user_id = $user_id;
    
                $commentsDao->create($comments);
    
            }
        
    } else {
        $message->createMessage("Informações inválidas!", "error", "index.php");
    }