<?php
    require_once("dao/userDao.php");
    require_once("models/user.php");
    require_once("models/post.php");
    require_once("models/message.php");

    class PostDao implements PostDaoInterface {

        public $url;
        public $conn;
        public $message;

        public function __construct(PDO $conn, $url){

            $this->url = $url;
            $this->conn = $conn;
            $this->message = new message($url);

        }

        public function buildPost($data){

            $post = new Post();

            $post->id = $data["id"];
            $post->title = $data["title"];
            $post->description = $data["description"];
            $post->imagem = $data["imagem"];
            $post->user_id = $data["user_id"];

            return $post;

        }
        
        public function findAll(){

        }
        
        public function getLatesPost(){

            $posts = [];

            $stmt = $this->conn->prepare("SELECT * FROM post 
                ORDER BY id DESC
                ");

            $stmt->execute();

            if($stmt->rowCount() > 0) {

                $data = $stmt->fetchAll();

                foreach($data as $post) {

                    $posts[] = $this->buildPost($post);
                }

            }

            return $posts;

        }

        public function getPostByUserId($id){

            $posts = [];

            $stmt = $this->conn->prepare("SELECT * FROM post 
                WHERE user_id = :user_id
                ");

            $stmt->bindParam(":user_id", $id);

            $stmt->execute();

            if($stmt->rowCount() > 0) {

                $data = $stmt->fetchAll();

                foreach($data as $post) {

                    $posts[] = $this->buildPost($post);
                }

            }

            return $posts;
        }
        
        public function getPostfindById($id){

            $post = [];

            $stmt = $this->conn->prepare("SELECT * FROM post
                WHERE id = :id
            ");

            $stmt->bindParam(":id", $id);

            $stmt->execute();

            if($stmt->rowCount() > 0) {

                $data = $stmt->fetch();
                $post = $this->buildPost($data);

                return $post;
            }

        }

        public function create(Post $post){

            $stmt = $this->conn->prepare("INSERT INTO post (
                title, description, imagem, user_id, comments_id
            ) VALUES (
                :title, :description, :imagem, :user_id, :comments_id
            )");

            $stmt->bindParam(":title", $post->title);
            $stmt->bindParam(":description", $post->description);
            $stmt->bindParam(":imagem", $post->imagem);
            $stmt->bindParam(":user_id", $post->user_id);
            $stmt->bindParam(":comments_id", $post->comments_id);

            $stmt->execute();

            $this->message->createMessage("Post criado com sucesso!", "success", "index.php");

        }

        public function update(Post $post){

            $stmt = $this->conn->prepare("UPDATE post SET 
                title = :title,
                description = :description,
                imagem = :imagem
                WHERE id = :id 
            ");

            $stmt->bindParam(":title", $post->title);
            $stmt->bindParam(":description", $post->description);
            $stmt->bindParam(":imagem", $post->imagem);
            $stmt->bindParam(":id", $post->id);

            $stmt->execute();

            $this->message->createMessage("dados atualizado com sucesso", "success", "profile.php");

        }

        public function destroy($id){

            $stmt = $this->conn->prepare("DELETE FROM post 
                WHERE id = :id
            ");

            $stmt->bindParam(":id", $id);

            $stmt->execute();

        }

    }