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

if($type === "register"){
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

    if($name && $lastname && $email && $password){
        if($password === $confirmpassword){
            if($userDao->findByEmail($email) === false){
                // CRIANDO UM USUÁRIO NO SISTEMA
                $user = new User();

                $userToken = $user->generateToken();
                $finalPassword = $user->generatePassword($password);

                $user->name = $name;
                $user->lastname = $lastname;
                $user->email = $email;
                $user->password = $finalPassword;
                $user->token = $userToken;

                $auth = true;

                $userDao->create($user, $auth);
            }else{
                $message->setMessage("E-mail já está cadastrados, por favor tente outro!", "error", "back");
            }
        }else{
            $message->setMessage("As senhas digitadas não são iguais!", "error", "back");    
        }
    }else{
        $message->setMessage("Por favot, preencha todos os campos", "error", "back");
    }

}elseif($type === "login"){
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");

    if($userDao->authenticateUser($email, $password)){
        $message->setMessage("Seja bem-vindo", "success", "editprofile.php");    
    }else{
        $message->setMessage("Usurário e/ou senha icorretos", "error", "back");                
    }
}else{
    $message->setMessage("Informações iválidas", "error", "index.php");                
}
