<?php 
    
    require_once("models/message.php");
    require_once("models/comments.php");
    require_once("dao/commentsDao.php");
    require_once("dao/userDao.php");

    class commentsDao implements commentsDaoInterface {

        public $url;
        public $conn;
        public $message;

        public function __construct($conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildComments($data){

            $comments = new Comments();

            $comments->id = $data['id'];
            $comments->comments = $data['comments'];
            $comments->user_id = $data['user_id'];
            $comments->post_id = $data['post_id'];

            return $comments;

        }

        public function create(Comments $comments){

            $stmt = $this->conn->prepare("INSERT INTO comments (
                comments, user_id, post_id
            ) VALUES (
                :comments, :user_id, :post_id
            )");

            $stmt->bindParam(":comments", $comments->comments);
            $stmt->bindParam(":user_id", $comments->user_id);
            $stmt->bindParam(":post_id", $comments->post_id);

            $stmt->execute();

            $this->message->createMessage("Comentário adicionado com sucesso!", "success", "index.php");

        }

        public function getCommentsByPost($id){

            $comments = [];

            $stmt = $this->conn->prepare("SELECT * FROM comments WHERE post_id = :post_id");

            $stmt->bindParam(":post_id", $id);

            $stmt->execute();

            if($stmt->rowCount() > 0){

                $data = $stmt->fetchAll();

                $userDao = new UserDao($this->conn, $this->url);

                foreach($data as $comment) {

                    $commentsObj = $this->buildComments($comment);

                    $user = $userDao->findById($commentsObj->user_id);

                    $commentsObj->user = $user;

                    $comments[] = $commentsObj;

                }

            }

            return $comments;
        }

    } 