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

// Verifica o tipo do formulário
if ($type === "register") {

  $name = filter_input(INPUT_POST, "name");
  $email = filter_input(INPUT_POST, "email");
  $password = filter_input(INPUT_POST, "password");
  $confirmpassword = filter_input(INPUT_POST, "confirmpassword");
  $caps_id = filter_input(INPUT_POST, "caps");
  $adm = filter_input(INPUT_POST, "adm");
  
  // Verifica dados minimos
  if ($name && $email && $password) {

    if ($password === $confirmpassword) {

      // Verificar se o e-mail já está cadastrdo no sistema
      if ($userDao->findByEmail($email) === false) {

        $user = new User();

        // Criação de token e senha
        $userToken = $user->generateToken();
        $finalPassword = $user->generatePassword($password);

        $user->name = $name;
        $user->email = $email;
        $user->password = $finalPassword;
        $user->token = $userToken;
        $user->adm = $adm;
        $user->caps_id = $caps_id;

        $userDao->create($user);
      } else {

        // Enviar uma msg de erro, usuário já existe
        $message->setMessage("Usuário já cadastrado, tente outro e-mail.", "error", "back");
      }
    } else {

      // Enviar uma msg de erro, de senhas não batem
      $message->setMessage("As senhas não são iguais.", "error", "back");
    }
  } else {

    // Enviar uma msg de erro, de dados faltantes
    $message->setMessage("Por favor, preencha todos os campos.", "error", "back");
  }
} else if ($type === "login") {

  $email = filter_input(INPUT_POST, "email");
  $password = filter_input(INPUT_POST, "password");
  // Tenta autenticar usuário
  if ($userDao->authenticateUser($email, $password)) {

    // Enviar uma msg de erro, de dados faltantes
    $message->setMessage("Seja bem-vindo!!.", "success", "index.php?file=home");
    // Redireciona o usuário, caso não conseguir autenticar  
  } else {
    // Enviar uma msg de erro, de dados faltantes
    $message->setMessage("Usuário ou senha incorretos.", "error", "back");
  }
} else {
  // Enviar uma msg de erro, de dados faltantes
  $message->setMessage("Informações inválidas!.", "error", "index.php?file=home");
}
