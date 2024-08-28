<?php 

    class Comments {

        public $id;
        public $comments;
        public $user_id;
        public $post_id;

    }

    Interface commentsDaoInterface {

        public function buildComments($data);
        public function create(Comments $Comments);
        public function getCommentsByPost($post);

    }

?>