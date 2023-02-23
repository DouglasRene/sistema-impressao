<?php

require_once __DIR__."/globals.php";
require_once __DIR__."/db.php";
require_once __DIR__."/../models/User.php";
require_once __DIR__."/../models/Message.php";
require_once __DIR__."/../dao/UserDAO.php";


$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);

// Resgata o tipo do formulário
$type = filter_input(INPUT_POST, "type");
// echo $type;exit;
// Atualizar usuário
if ($type === "update") {

  // Resgata dados do usuário
  $userData = $userDao->verifyToken();

  // Recever dados do post
  $name = filter_input(INPUT_POST, "name");
  $email = filter_input(INPUT_POST, "email");
  $caps_id = filter_input(INPUT_POST, "caps");

  // Preencher os dados do usuário
  $userData->name = $name;
  $userData->email = $email;
  $userData->caps_id = $caps_id;


  $userDao->update($userData);
} else if ($type === "changepassword") {

  // Receber dados do post
  $password = filter_input(INPUT_POST, "password");
  $confirmpassword = filter_input(INPUT_POST, "confirmpassword");
  // Resgata dados do usuário
  $userData = $userDao->verifyToken();
  
  $id = $userData->id;
  
  if ($password == $confirmpassword) {
    //   echo $password ." - ". $confirmpassword;exit;

    // Criar um novo objeto de usuário
    $user = new User();

    $finalPassword = $user->generatePassword($password);

    $user->password = $finalPassword;
    $user->id = $id;

    $userDao->changePassword($user);
  } else {
    $message->setMessage("As senhas não são inguais!", "error", "back");
  }
} else if ($type === "update_usr") {

    $id = filter_input(INPUT_POST, "id");
    // Resgata dados do usuário
    $userData = $userDao->findById($id);

    // Receber dados do post
    $caps_id = filter_input(INPUT_POST, "caps");
  
    // Preencher os dados do usuário
    $userData->caps_id = $caps_id;
  
    $userDao->update($userData, "gerenciarcontas");
} else if($type === "delete") {
  $id = filter_input(INPUT_POST, "id");

  $userDao->delete($id);
} else {
  $message->setMessage("Informações inválidas!", "error", "index.php");
}
