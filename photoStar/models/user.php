<?php

    class User {

        public $id;
        public $name;
        public $lastname;
        public $bio;
        public $imagem;
        public $password;
        public $email;
        public $token;

        public function getNameLastname($user){

            $this->name = $user->name;
            $this->lastname = $user->lastname;

            return "$this->name " . "$this->lastname";

        }

        public function generateToken() {

            return bin2hex(random_bytes(50));

        }

        public function generatePassword($password){

            return password_hash($password, PASSWORD_DEFAULT);

        }

        public function imageGenerateName(){

            return bin2hex(random_bytes(60)) . ".jpg";

        }

    }

    interface UserDaointerface {

        public function buildUser($data);
        public function create(User $User, $authUser = false);
        public function update(User $user, $redirect = true);
        public function verifyToken($protected = false);
        public function setTokenToSession($token, $redirect = true);
        public function authenticateUser($email, $password);
        public function findByEmail($email);
        public function findById($id);
        public function findByToken($token);
        public function destroyToken();
        public function changePassword(User $user);

    }