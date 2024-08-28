<?php

    class message {

        private $url;

        public function __construct($url) {
            $this->url = $url;
        }

        public function createMessage($msg, $type, $redirect = "index.php") {

            //inserindo a mensagem na session
            $_SESSION["msg"] = $msg;
            $_SESSION["type"] = $type;
            
            if($redirect != "back") {
                header("location: " . $redirect);
            } else {
                header("location: " . $_SERVER["HTTP_REFERER"]);
            }

        }

        //essa funcao insere a mensagem no header
        public function insertMessage() {

            if(!empty($_SESSION["msg"])) {

                return [
                    "msg" => $_SESSION["msg"],
                    "type" => $_SESSION["type"]
                ];

            } else {
                return false;
            }

        }

        public function clearMessage() {

            $_SESSION["msg"] = "";
            $_SESSION["type"] = "";

        }

    }