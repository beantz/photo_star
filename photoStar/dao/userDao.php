<?php

    require_once("models/user.php");
    require_once("models/message.php");
    require_once("globals.php");

    class userDao implements UserDaointerface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {

            $this->conn = $conn;
            $this->url = $url;
            $this->message = new message($url);

        }

        public function buildUser($data) {

            $user = new User();

            $user->id = $data['id'];
            $user->name = $data['name'];
            $user->lastname = $data['lastname'];
            $user->bio = $data['bio'];
            $user->imagem = $data['imagem'];
            $user->password = $data['password'];
            $user->email = $data['email'];
            $user->token = $data['token'];

            return $user;

        }

        /* esse user verde garante que a variavel esperada na função seja seja uma 
        instancia do obj user */
        public function create(User $user, $authUser = false) {

            $stmt = $this->conn->prepare("INSERT INTO user( 
                name, lastname, email, password, token
            )   Values (
                :name, :lastname, :email, :password, :token
            )");

            $stmt->bindParam(":name", $user->name);
            $stmt->bindParam(":lastname", $user->lastname);
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":token", $user->token);

            $stmt->execute();

            if($authUser) {
                $this->setTokenToSession($user->token);
            }

        }

        public function update(User $user, $redirect = true) {

            $stmt = $this->conn->prepare("UPDATE user SET 
                name = :name,
                lastname = :lastname,
                email = :email,
                imagem = :imagem,
                bio = :bio,
                token = :token
                WHERE id = :id
            ");
                    

            $stmt->bindParam(":name", $user->name);
            $stmt->bindParam(":lastname", $user->lastname);
            $stmt->bindParam(":bio", $user->bio);
            $stmt->bindParam(":imagem", $user->imagem);
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":token", $user->token);
            $stmt->bindParam(":id", $user->id);

            $stmt->execute();

            if($redirect) {
                $this->message->createMessage("Dados atualizados com sucesso", "success", "editprofile.php");
            }

        }

        public function verifyToken($protected = false) {

            if(!empty($_SESSION["token"])) {

                $token = $_SESSION["token"];

                $user = $this->findByToken($token);

                if($user) {

                    return $user;

                } else if($protected) {

                    $this->message->createMessage("Faça autenticação para acessar essa pagina", "error", "index.php");

                }

            } else if($protected) {

                $this->message->createMessage("Faça autenticação para acessar essa pagina", "error", "index.php");

            }

        }

        public function setTokenToSession($token, $redirect = true) {

            $_SESSION["token"] = $token;

            if($redirect) {

                $this->message->createMessage("Seja bem vindo, cadastro feito com sucesso", "success", "editprofile.php");

            }

        }

        public function authenticateUser($email, $password) {

            $user = $this->findByEmail($email);

            if($user) {

                if(password_verify($password, $user->password)) {

                    $token = $user->generateToken();

                    $this->setTokenToSession($token, false);

                    $user->token = $token;

                    $this->update($user, false);

                    return true;

                } else {
                    return false;
                }

            } else {
                return false;
            }

        }

        public function findByEmail($email) {

            if($email != 0) {

                $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = :email");

                $stmt->bindParam(":email", $email);

                $stmt->execute();

                if($stmt->rowCount() > 0) {

                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;

                } else {

                    return false;

                }

            } else {
                return false;
            }
        }

        public function findById($id) {

            if($id != 0) {

                $stmt = $this->conn->prepare("SELECT * FROM user WHERE id = :id");

                $stmt->bindParam(":id", $id);

                $stmt->execute();

                if($stmt->rowCount() > 0) {

                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;

                } else {

                    return false;

                }

            } else {
                return false;
            }

        }

        public function findByToken($token) {

            if($token != 0) {

                $stmt = $this->conn->prepare("SELECT * FROM user WHERE token = :token");

                $stmt->bindParam(":token", $token);

                $stmt->execute();

                if($stmt->rowCount() > 0) {

                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;

                } else {

                    return false;

                }

            } else {

                return false;

            }

        }

        public function destroyToken() {

            $_SESSION["token"] = "";

            $this->message->createMessage("você fez o logout com sucesso", "success", "index.php");
            
        }

        public function changePassword(User $user) {

            $stmt = $this->conn->prepare("UPDATE user SET
                password = :password
                WHERE id = :id
            ");

            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":id", $user->id);

            $stmt->execute();

            $this->message->createMessage("Senha alterada com sucesso", "success", "editprofile.php");

        }

    }