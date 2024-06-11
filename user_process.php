<?php

require_once("globals.php");
require_once("db.php");
require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);
$user = new User();

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

    // Trabalhando com imagem:
    if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])){

        $image = $_FILES["image"];
        $imageTypes = ["image/jpg", "image/jpeg", "image/png",];
        $jpgArray = ["image/jpg", "image/jpeg"];

        if(in_array($image["type"], $imageTypes)){

            if(in_array($image["type"], $jpgArray)){
                $imageFile = imagecreatefromjpeg($image["tmp_name"]);
            }else {
                $imageFile = imagecreatefrompng($image["tmp_name"]);
            }

            $imageName = $user->imageGenerateName();
            imagejpeg($imageFile, "./img/users/".$imageName, 100);
            $userData->image = $imageName;
        }else {
            $message->setMessage("Tipo de imagem inválida, por favor insira apenas (Jpg, Jpeg e Png)", "error", "back");
        }
    }


    $userDao->update($userData);
} else if ($type === "changepassword") {
} else {
    $message->setMessage("Informações iválidas", "error", "index.php");
}
