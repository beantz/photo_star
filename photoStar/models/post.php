<?php

    class Post {

        public $id;
        public $title;
        public $imagem;
        public $description;
        public $user_id;

        public function imageGenerateName(){

            return bin2hex(random_bytes(60)) . ".jpg";

        }
    }

    interface PostDaoInterface {

        //criar um obj de post
        public function buildPost($data);
        //pegar todos os post
        public function findAll();
        //pegar todos os post em ordem decrescente
        public function getLatesPost();
        public function getPostByUserId($id);
        //pegar um post pelo id dele
        public function getPostfindById($id);
        public function create(Post $post);
        public function update(Post $post);
        public function destroy($id);

    }