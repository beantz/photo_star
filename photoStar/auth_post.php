<?php
    /* processo de criar um post e mandar pro banco de dados */
    require_once("models/message.php");
    require_once("models/post.php");
    require_once("dao/userDao.php");
    require_once("dao/postDao.php");
    require_once("db.php");
    require_once("globals.php");

    $userDao = new userDao($conn, $BASE_URL);
    $message = new message($BASE_URL);
    $postDao = new PostDao($conn, $BASE_URL);

    $userData = $userDao->verifyToken();

    $id = $userData->id;

    $type = filter_input(INPUT_POST, "type");

    if($type == "createpost") {

        $title = filter_input(INPUT_POST, "title");
        $description = filter_input(INPUT_POST, "description");
        $user_id = $id;

        $post = new Post();

        if(!empty($title) && !empty($description) && !empty($_FILES["image"])) {
            
            $post->title = $title;
            $post->description = $description;
            $post->user_id = $user_id;
                
            $image = $_FILES["image"];

            if(in_array($image["type"], ["image/jpeg", "image/jpg", "image/png"])) {

                if(in_array($image["type"], ["image/jpeg", "image/jpg"])) {

                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);

                } else {
                    $imageFile = imagecreatefrompng($image["tmp_name"]);
                }

                $imageName = $post->imageGenerateName();

                imagejpeg($imageFile, "./img/post/" . $imageName, 100);

                $post->imagem = $imageName;

            } else {
                $message->createMessage("a imagem deve ser nos tipo: jpeg, jpg ou png", "error", "back");
            }

            $postDao->create($post);

        } else {
            $message->createMessage("Adicione título, descrição e imagem", "error", "back");
        }

    } else if($type == "editpost"){

        $title = filter_input(INPUT_POST, "title");
        $description = filter_input(INPUT_POST, "description");
        $id = filter_input(INPUT_POST, "id");

        $post = $postDao->getPostfindById($id);

        if($post) {

            if($post->user_id === $userData->id){

                if(!empty($title) && !empty($description) && !empty($id)) {

                    $post->title = $title;
                    $post->description = $description;
                    
                    $image = $_FILES["image"];

                    if(in_array($image["type"], ["image/jpeg", "image/jpg", "image/png"])) {

                        if(in_array($image["type"], ["image/jpeg", "image/jpg"])) {

                            $imageFile = imagecreatefromjpeg($image["tmp_name"]);

                        } else {
                            $imageFile = imagecreatefrompng($image["tmp_name"]);
                        }

                        $imageName = $post->imageGenerateName();

                        imagejpeg($imageFile, "./img/post/" . $imageName, 100);

                        $post->imagem = $imageName;

                    } else {
                        $message->createMessage("a imagem deve ser nos tipo: jpeg, jpg ou png", "error", "back");
                    }

                    $postDao->update($post); 

                }

            }

        }

    } else if($type == "delete") {

        $id = filter_input(INPUT_POST, "id");

        if($id) {

            $postDao->destroy($id);

            $message->createMessage("post removido com sucesso", "success", "back");

        }

    }