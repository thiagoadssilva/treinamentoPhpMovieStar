<?php

require_once("globals.php");
require_once("db.php");
require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);

//A função filter_input() no PHP é uma ferramenta poderosa para obter e filtrar dados de entrada provenientes de diferentes fontes, como formulários HTML, cookies, variáveis de ambiente e muito mais. 
$type = filter_input(INPUT_POST, "type");

if ($type === "update") {
    $userData = $userDao->verifyToken();

    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $bio = filter_input(INPUT_POST, "bio");

    $userData->name = $name;
    $userData->lastname = $lastname;
    $userData->email = $email;
    $userData->bio = $bio;

    $userDao->update($userData);
} else if ($type === "changepassword") {
} else {
    $message->setMessage("Informações iválidas", "error", "index.php");
}
