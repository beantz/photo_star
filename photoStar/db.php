<?php

    $dbname = "galery";
    $host = "localhost";
    $pass = "12345";
    $user = "bea";

    $conn = new PDO ("mysql:host=$host;dbname=$dbname", $user, $pass);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
